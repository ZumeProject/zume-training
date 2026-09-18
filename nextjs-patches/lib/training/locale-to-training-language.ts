/**
 * Maps funnel route locale codes to the `language` query param values stored on
 * public training groups (`language_note` in zume_plans).
 *
 * IMPORTANT: the API matches these stored strings exactly. ISO locale codes often
 * do NOT work (e.g. `language=es` returns 0; Spanish groups use `Espanol`).
 *
 * Verified against GET /api/v1/coaching/groups/public (2026-09-18):
 *   en + English → English trainings (`en`, `English`)
 *   es → Espanol   → Spanish trainings only
 *   pt → pt        → Portuguese trainings only
 *
 * When a locale has multiple stored variants, return each value — the client
 * should fetch once per value and merge/dedupe by public_id.
 */
export const LOCALE_TO_TRAINING_LANGUAGE_API_VALUES: Record<string, string[]> = {
  en: ["en", "English"],
  es: ["Espanol"],
  pt: ["pt"],
};

/**
 * Returns API `language` param values for a route locale.
 * Falls back to the locale code itself for locales without an explicit map
 * (callers should treat an empty result set as “no trainings in this language”).
 */
export function getTrainingLanguageApiValues(locale: string): string[] {
  const mapped = LOCALE_TO_TRAINING_LANGUAGE_API_VALUES[locale];
  if (mapped?.length) {
    return mapped;
  }

  return [locale];
}

/** Allowed stored `group.language` values for a locale (post-fetch safety net). */
export function getAllowedTrainingLanguageLabels(locale: string): string[] {
  return getTrainingLanguageApiValues(locale);
}
