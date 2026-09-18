import { FunnelGoogleAnalytics } from "@/components/funnel/FunnelGoogleAnalytics";
import { JoinFunnelLayout } from "@/components/funnel/JoinFunnelLayout";
import { FunnelJoinTrainingClient } from "@/components/training/FunnelJoinTrainingClient";

type JoinFunnelPageProps = {
  locale: string;
};

export function JoinFunnelPage({ locale }: JoinFunnelPageProps) {
  return (
    <>
      <FunnelGoogleAnalytics />
      <JoinFunnelLayout testId="funnel-join-page">
        <div className="rounded-2xl bg-white p-6 shadow-sm sm:p-8">
          <FunnelJoinTrainingClient locale={locale} />
        </div>
      </JoinFunnelLayout>
    </>
  );
}
