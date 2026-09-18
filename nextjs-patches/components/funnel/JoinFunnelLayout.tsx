import type { ReactNode } from "react";
import { JoinFunnelExplainer } from "@/components/funnel/JoinFunnelExplainer";

type JoinFunnelLayoutProps = {
  testId: string;
  children: ReactNode;
};

export function JoinFunnelLayout({ testId, children }: JoinFunnelLayoutProps) {
  return (
    <div className="mx-auto max-w-6xl px-4 py-10" data-testid={testId}>
      <div className="grid items-start gap-10 lg:grid-cols-2 lg:gap-14">
        <JoinFunnelExplainer />
        <div className="min-w-0">{children}</div>
      </div>
    </div>
  );
}
