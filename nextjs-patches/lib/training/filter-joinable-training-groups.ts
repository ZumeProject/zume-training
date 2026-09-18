import { getAllowedTrainingLanguageLabels } from "@/lib/training/locale-to-training-language";

export type PublicTrainingGroup = {
  id: number;
  public_id: string;
  name: string;
  language?: string | null;
  next_session_date?: string | null;
  session_number?: number | null;
  start_time?: string | null;
  timezone?: string | null;
};

function todayIsoDate(): string {
  return new Date().toISOString().slice(0, 10);
}

/** Exclude trainings whose next session date is in the past. */
export function isOpenTrainingGroup(group: PublicTrainingGroup): boolean {
  const nextSession = group.next_session_date?.trim();
  if (!nextSession) {
    // No scheduled next session — keep visible (coach may still be accepting).
    return true;
  }

  return nextSession >= todayIsoDate();
}

export function groupMatchesLocaleLanguage(
  group: PublicTrainingGroup,
  locale: string,
): boolean {
  const label = group.language?.trim();
  if (!label) {
    return false;
  }

  const allowed = new Set(
    getAllowedTrainingLanguageLabels(locale).map((value) => value.toLowerCase()),
  );

  return allowed.has(label.toLowerCase());
}

export function dedupeTrainingGroupsByPublicId<T extends PublicTrainingGroup>(
  groups: T[],
): T[] {
  const seen = new Set<string>();
  const result: T[] = [];

  for (const group of groups) {
    if (seen.has(group.public_id)) continue;
    seen.add(group.public_id);
    result.push(group);
  }

  return result;
}

export function filterJoinableTrainingGroupsForLocale<T extends PublicTrainingGroup>(
  groups: T[],
  locale: string,
): T[] {
  return dedupeTrainingGroupsByPublicId(groups)
    .filter((group) => groupMatchesLocaleLanguage(group, locale))
    .filter(isOpenTrainingGroup);
}
