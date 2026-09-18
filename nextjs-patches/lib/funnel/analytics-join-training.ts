import {
  bindGtagQueue,
  emitFunnelAdsConversion,
  getFunnelGaMeasurementId,
  getFunnelSessionStorage,
  isFunnelAnalyticsAllowed,
  readPrivacyConsentCookie,
} from "@/lib/funnel/analytics";

/** DOM event for GTM — mirrors `zume-funnel-signup-completed` / `zume-funnel-coach-submitted`. */
export const FUNNEL_JOIN_TRAINING_DOM_EVENT =
  "zume-funnel-join-training-completed";

/**
 * Google Ads conversion label — parent creates the action after deploy.
 * Same env-var pattern as coach/signup labels in the main analytics module.
 */
export const JOIN_TRAINING_ADS_CONVERSION_SEND_TO =
  process.env.NEXT_PUBLIC_JOIN_TRAINING_ADS_CONVERSION_SEND_TO?.trim() ||
  "";

export type JoinTrainingConversionPayload = {
  locale: string;
  publicId: string;
  groupName: string;
};

/**
 * Low-level emitter — called by FunnelGoogleAnalytics listener and report helper.
 * Uses shared `emitFunnelAdsConversion` for session dedupe (same as /go Sign-up).
 */
export function emitFunnelJoinTrainingCompletedTracking(options?: {
  gtag?: (...args: unknown[]) => void;
  storage?: Storage | null;
  payload?: JoinTrainingConversionPayload;
}) {
  const gtag = options?.gtag;
  const storage = options?.storage ?? null;
  const measurementId = getFunnelGaMeasurementId();

  if (typeof gtag === "function" && measurementId) {
    gtag("event", "join_training", {
      send_to: measurementId,
      event_timeout: 2000,
      locale: options?.payload?.locale,
      group_public_id: options?.payload?.publicId,
      group_name: options?.payload?.groupName,
    });
  }

  if (JOIN_TRAINING_ADS_CONVERSION_SEND_TO && typeof gtag === "function") {
    emitFunnelAdsConversion(JOIN_TRAINING_ADS_CONVERSION_SEND_TO, {
      gtag,
      storage,
    });
  }
}

/** Public API — mirrors `reportFunnelSignupCompleted` / `reportFunnelCoachSubmitted`. */
export function reportFunnelJoinTrainingCompleted(
  payload: JoinTrainingConversionPayload,
) {
  if (isFunnelAnalyticsAllowed(readPrivacyConsentCookie())) {
    bindGtagQueue(window);
    emitFunnelJoinTrainingCompletedTracking({
      gtag: window.gtag,
      storage: getFunnelSessionStorage(),
      payload,
    });
  }

  window.dispatchEvent(
    new CustomEvent(FUNNEL_JOIN_TRAINING_DOM_EVENT, { detail: payload }),
  );
}
