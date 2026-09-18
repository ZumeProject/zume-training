"use client";

import Image from "next/image";
import { useTranslations } from "next-intl";

const BENEFITS = [
  {
    imageSrc: "/images/funnel/join-training-online.svg",
    titleKey: "benefitOnlineTitle",
    descKey: "benefitOnlineDesc",
    imageAltKey: "benefitOnlineAlt",
  },
  {
    imageSrc: "/images/funnel/join-training-coach.svg",
    titleKey: "benefitCoachTitle",
    descKey: "benefitCoachDesc",
    imageAltKey: "benefitCoachAlt",
  },
  {
    imageSrc: "/images/funnel/join-training-community.svg",
    titleKey: "benefitCommunityTitle",
    descKey: "benefitCommunityDesc",
    imageAltKey: "benefitCommunityAlt",
  },
] as const;

export function JoinFunnelExplainer() {
  const t = useTranslations("pages.join");

  return (
    <section data-testid="funnel-join-explainer">
      <h1 className="text-3xl font-bold text-zume-brand md:text-4xl">{t("heading")}</h1>
      <p className="mt-4 text-base leading-7 text-gray-900 md:text-lg">{t("intro")}</p>
      <div className="mt-8 grid gap-4">
        {BENEFITS.map((benefit) => (
          <article
            key={benefit.titleKey}
            className="flex items-start gap-4 rounded-xl border border-gray-200 bg-white px-4 py-4 shadow-sm"
          >
            <Image
              src={benefit.imageSrc}
              alt={t(benefit.imageAltKey)}
              width={72}
              height={60}
              className="h-[60px] w-auto shrink-0"
            />
            <div>
              <h2 className="text-lg font-semibold text-zume-brand">{t(benefit.titleKey)}</h2>
              <p className="mt-1 text-sm leading-6 text-gray-900">{t(benefit.descKey)}</p>
            </div>
          </article>
        ))}
      </div>
    </section>
  );
}
