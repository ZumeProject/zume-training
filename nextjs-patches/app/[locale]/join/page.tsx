import { notFound } from "next/navigation";
import { isValidLocale } from "@/lib/i18n/languages";
import { JoinFunnelPage } from "@/components/funnel/JoinFunnelPage";

type LocaleJoinPageProps = {
  params: Promise<{ locale: string }>;
};

export default async function LocaleJoinPage({ params }: LocaleJoinPageProps) {
  const { locale } = await params;

  if (!isValidLocale(locale)) {
    notFound();
  }

  return <JoinFunnelPage locale={locale} />;
}
