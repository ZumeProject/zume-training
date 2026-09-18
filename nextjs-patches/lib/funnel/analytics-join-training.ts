import {
  GOOGLE_ADS_ID,
  bindGtagQueue,
  getFunnelGaMeasurementId,
  getFunnelSessionStorage,
  isFunnelAnalyticsAllowed,
  readPrivacyConsentCookie,
} from "@/lib/funnel/analytics";

/** DOM event name for GTM dataLayer listeners (fires once per successful join). */
export const FUNNEL_JOIN_TRAINING_DOM_EVENT =
  "zume-funnel-join-training-completed";

/**
 * Google Ads conversion label placeholder.
 * Parent creates the conversion action after deploy and sets this env var.
 */
export const JOIN_TRAINING_ADS_CONVERSION_SEND_TO =
  process.env.NEXT_PUBLIC_JOIN_TRAINING_ADS_CONVERSION_SEND_TO?.trim() ||
  "";

export type JoinTrainingConversionPayload = {
  locale: string;
  publicId: string;
  groupName: string;
};

function markJoinTrainingConversionFired(sendTo: string, storage: Storage | null) {
  if (!storage) return;
  try {
    storage.setItem(`zume-ads-conversion:${sendTo}`, "1");
  } catch {
    // ignore quota / private mode
  }
}

function hasJoinTrainingConversionFired(
  sendTo: string,
  storage: Storage | null,
): boolean {
  if (!storage) return false;
  try {
    return storage.getItem(`zume-ads-conversion:${sendTo}`) === "1";
  } catch {
    return false;
  }
}

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

  const adsSendTo = JOIN_TRAINING_ADS_CONVERSION_SEND_TO;
  if (
    adsSendTo &&
    typeof gtag === "function" &&
    !hasJoinTrainingConversionFired(adsSendTo, storage)
  ) {
    gtag("event", "conversion", {
      send_to: adsSendTo,
      event_timeout: 2000,
    });
    markJoinTrainingConversionFired(adsSendTo, storage);
  }
}

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
