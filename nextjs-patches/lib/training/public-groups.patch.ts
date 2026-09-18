/**
 * Ensure fetchPublicTrainingGroups forwards the API `language` param.
 * Production JoinATrainingClient currently only passes `locale` — that is NOT
 * sufficient for language filtering.
 *
 * async function fetchPublicTrainingGroups({
 *   locale,
 *   language,
 *   timezone,
 * }: {
 *   locale?: string;
 *   language?: string;
 *   timezone?: string;
 * }) {
 *   const params = new URLSearchParams();
 *   if (language) params.append("language", language);
 *   if (timezone) params.append("timezone", timezone);
 *   if (locale) params.append("locale", locale);
 *   ...
 * }
 */
