"use client";

import Link from "next/link";
import { useCallback, useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { useTranslations } from "next-intl";
import { Check } from "lucide-react";

import { useAuth } from "@/components/auth/AuthProvider";
import { buildLanguageUrl } from "@/lib/i18n/urls";
import {
  joinTrainingGroup,
  notifyMeTrainingGroups,
  type PublicTrainingGroup,
} from "@/lib/training/public-groups";
import { fetchJoinableTrainingGroupsForLocale } from "@/lib/training/fetch-training-groups-for-locale";
import { getTrainingLanguageApiValues } from "@/lib/training/locale-to-training-language";
import { reportFunnelJoinTrainingCompleted } from "@/lib/funnel/analytics-join-training";

type FunnelJoinTrainingClientProps = {
  locale: string;
};

export function FunnelJoinTrainingClient({ locale }: FunnelJoinTrainingClientProps) {
  const t = useTranslations("pages.join");
  const router = useRouter();
  const { user, isAuthenticated, isLoading: authLoading } = useAuth();

  const [groups, setGroups] = useState<PublicTrainingGroup[]>([]);
  const [loading, setLoading] = useState(true);
  const [loadError, setLoadError] = useState<string | null>(null);
  const [joiningId, setJoiningId] = useState<string | null>(null);
  const [joinedIds, setJoinedIds] = useState<Set<string>>(new Set());
  const [actionError, setActionError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);
  const [notifyOpen, setNotifyOpen] = useState(false);
  const [notifyEmail, setNotifyEmail] = useState("");
  const [notifySubmitting, setNotifySubmitting] = useState(false);
  const [notifySubmitted, setNotifySubmitted] = useState(false);

  const coachUrl = buildLanguageUrl(locale, "/go");

  const loadGroups = useCallback(async () => {
    setLoading(true);
    setLoadError(null);
    try {
      const joinableGroups = await fetchJoinableTrainingGroupsForLocale(locale);
      setGroups(joinableGroups);
    } catch (error) {
      setLoadError(
        error instanceof Error ? error.message : t("loadError"),
      );
    } finally {
      setLoading(false);
    }
  }, [locale, t]);

  useEffect(() => {
    void loadGroups();
  }, [loadGroups]);

  const handleJoin = async (publicId: string) => {
    if (authLoading) return;

    if (!isAuthenticated) {
      router.push(buildLanguageUrl(locale, `/join-a-training-group/${publicId}`));
      return;
    }

    setJoiningId(publicId);
    setActionError(null);
    setSuccessMessage(null);

    try {
      const result = await joinTrainingGroup(publicId);
      setJoinedIds((prev) => new Set([...prev, publicId]));

      const group = groups.find((item) => item.public_id === publicId);
      reportFunnelJoinTrainingCompleted({
        locale,
        publicId,
        groupName: result.group_name || group?.name || "",
      });

      setSuccessMessage(
        t("joinSuccess", {
          groupName: result.group_name,
          coachName: result.coach_name ?? "",
        }),
      );

      setTimeout(() => {
        router.push(buildLanguageUrl(locale, "/dashboard/training/my-training"));
      }, 2000);
    } catch (error) {
      const message =
        error instanceof Error ? error.message : t("alreadyMember");

      if (message.includes("already a member")) {
        setJoinedIds((prev) => new Set([...prev, publicId]));
        setTimeout(() => {
          router.push(buildLanguageUrl(locale, "/dashboard/training/my-training"));
        }, 2000);
      } else {
        setActionError(message);
      }
    } finally {
      setJoiningId(null);
    }
  };

  const handleNotify = async (event?: React.FormEvent) => {
    event?.preventDefault();
    setActionError(null);
    setSuccessMessage(null);

    const email = (isAuthenticated && user?.email ? user.email : notifyEmail).trim();
    if (!email) {
      setNotifyOpen(true);
      return;
    }

    setNotifySubmitting(true);
    try {
      await notifyMeTrainingGroups({ email, locale });
      setNotifySubmitted(true);
      setNotifyOpen(false);
      setNotifyEmail("");
      setSuccessMessage(t("notifySuccess"));
    } catch {
      setActionError(t("notifyError"));
    } finally {
      setNotifySubmitting(false);
    }
  };

  const languageApiValues = getTrainingLanguageApiValues(locale).join(",");

  return (
    <div
      className="space-y-6"
      data-testid="funnel-join-training-list"
      data-locale={locale}
      data-language-api-values={languageApiValues}
    >
      {loadError && (
        <div className="rounded-lg border border-zume-error-border bg-zume-error-fade px-4 py-3 text-sm text-zume-error-dark">
          {loadError}
        </div>
      )}
      {successMessage && (
        <div className="rounded-lg border border-zume-success-border bg-zume-success-fade px-4 py-3 text-sm text-zume-success-darker">
          {successMessage}
        </div>
      )}
      {actionError && (
        <div className="rounded-lg border border-zume-error-border bg-zume-error-fade px-4 py-3 text-sm text-zume-error-dark">
          {actionError}
        </div>
      )}

      {loading ? (
        <div className="flex justify-center py-16" data-testid="funnel-join-loading">
          <div className="h-10 w-10 animate-spin rounded-full border-2 border-zume-gray-300 border-t-zume-brand" />
        </div>
      ) : groups.length === 0 ? (
        <div
          className="rounded-lg border border-zume-gray-200 bg-white p-8 text-center"
          data-testid="funnel-join-empty"
        >
          <p className="mb-4 text-zume-gray-600">{t("emptyState")}</p>
          <p className="mb-8 text-sm text-zume-gray-600">{t("emptyCoachPrompt")}</p>
          <div className="flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
            <Link href={coachUrl} className="btn btn-primary rounded-full px-6 py-2.5">
              {t("coachCta")}
            </Link>
            <button
              type="button"
              onClick={() => setNotifyOpen(true)}
              className="btn btn-outline rounded-full px-6 py-2.5 border-2 border-zume-brand-light text-zume-brand-light hover:bg-zume-brand-fade hover:border-zume-brand-light"
            >
              {t("notifyMeCta")}
            </button>
          </div>
        </div>
      ) : (
        <div className="overflow-x-auto rounded-lg border border-zume-gray-200 bg-white">
          <table className="min-w-full divide-y divide-zume-gray-200">
            <thead className="bg-zume-gray-100">
              <tr>
                <th className="px-4 py-3 text-left text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerName")}
                </th>
                <th className="px-4 py-3 text-left text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerSession")}
                </th>
                <th className="px-4 py-3 text-left text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerNextSession")}
                </th>
                <th className="px-4 py-3 text-left text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerStartTime")}
                </th>
                <th className="px-4 py-3 text-left text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerTimezone")}
                </th>
                <th className="px-4 py-3 text-right text-xs font-semibold uppercase text-zume-gray-700">
                  {t("headerAction")}
                </th>
              </tr>
            </thead>
            <tbody className="divide-y divide-zume-gray-200">
              {groups.map((group, index) => (
                <tr key={group.id} className={index % 2 === 1 ? "bg-zume-gray-50/50" : ""}>
                  <td className="px-4 py-3 text-sm text-zume-gray-900">{group.name}</td>
                  <td className="px-4 py-3 text-sm text-zume-gray-700">{group.session_number}</td>
                  <td className="px-4 py-3 text-sm text-zume-gray-700">
                    {group.next_session_date || ""}
                  </td>
                  <td className="px-4 py-3 text-sm text-zume-gray-700">{group.start_time}</td>
                  <td className="px-4 py-3 text-sm text-zume-gray-700">{group.timezone}</td>
                  <td className="px-4 py-3 text-right">
                    {joinedIds.has(group.public_id) ? (
                      <button
                        type="button"
                        disabled
                        className="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full bg-[color-mix(in_srgb,var(--z-success)_18%,white)] px-4 py-2 text-sm font-medium text-[color-mix(in_srgb,var(--z-success)_55%,black)]"
                      >
                        <Check className="h-4 w-4 shrink-0" aria-hidden />
                        {t("joined")}
                      </button>
                    ) : (
                      <button
                        type="button"
                        onClick={() => handleJoin(group.public_id)}
                        disabled={joiningId === group.public_id}
                        className="inline-flex items-center gap-1.5 rounded-full bg-zume-brand-light px-4 py-2 text-sm font-medium uppercase text-white hover:bg-zume-brand disabled:cursor-not-allowed disabled:opacity-50"
                      >
                        {joiningId === group.public_id ? t("joining") : t("join")}
                      </button>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && groups.length > 0 && (
        <div className="flex justify-center pt-4">
          <button
            type="button"
            onClick={() => setNotifyOpen(true)}
            className="btn btn-outline rounded-full border-2 border-zume-brand-light px-6 py-2.5 text-zume-brand-light hover:border-zume-brand-light hover:bg-zume-brand-fade"
          >
            {t("notifyMeCta")}
          </button>
        </div>
      )}

      {notifyOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
          <div className="mx-4 w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
            <h3 className="mb-4 text-lg font-semibold text-zume-gray-900">{t("notifyTitle")}</h3>
            {notifySubmitted ? (
              <div>
                <p className="text-zume-gray-600">{t("notifySuccess")}</p>
                <button
                  type="button"
                  onClick={() => {
                    setNotifyOpen(false);
                    setNotifySubmitted(false);
                    setNotifyEmail("");
                  }}
                  className="btn btn-primary mt-4"
                >
                  {t("close")}
                </button>
              </div>
            ) : (
              <form onSubmit={handleNotify} className="space-y-4">
                <div>
                  <label
                    htmlFor="funnel-join-notify-email"
                    className="mb-1 block text-sm font-medium text-zume-gray-700"
                  >
                    {t("notifyEmailLabel")}
                  </label>
                  <input
                    id="funnel-join-notify-email"
                    type="email"
                    required={!isAuthenticated}
                    value={isAuthenticated ? user?.email ?? "" : notifyEmail}
                    onChange={(event) => setNotifyEmail(event.target.value)}
                    readOnly={isAuthenticated}
                    placeholder="you@example.com"
                    className="w-full rounded-md border border-zume-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-zume-brand"
                  />
                </div>
                <div className="flex justify-end gap-2">
                  <button
                    type="button"
                    onClick={() => {
                      setNotifyOpen(false);
                      setNotifyEmail("");
                    }}
                    className="btn btn-outline"
                  >
                    {t("cancel")}
                  </button>
                  <button type="submit" disabled={notifySubmitting} className="btn btn-primary">
                    {notifySubmitting ? t("submitting") : t("subscribe")}
                  </button>
                </div>
              </form>
            )}
          </div>
        </div>
      )}
    </div>
  );
}
