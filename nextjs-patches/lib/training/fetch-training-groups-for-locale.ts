import {
  fetchPublicTrainingGroups,
  type PublicTrainingGroup,
} from "@/lib/training/public-groups";
import { getTrainingLanguageApiValues } from "@/lib/training/locale-to-training-language";
import { filterJoinableTrainingGroupsForLocale } from "@/lib/training/filter-joinable-training-groups";

/**
 * Fetches joinable public trainings for a funnel locale.
 *
 * 1. Resolves route locale → one or more API `language` param values.
 * 2. Fetches each language slice (locale is still passed for API formatting).
 * 3. Merges, dedupes, enforces language label match, drops past sessions.
 */
export async function fetchJoinableTrainingGroupsForLocale(
  locale: string,
): Promise<PublicTrainingGroup[]> {
  const languageValues = getTrainingLanguageApiValues(locale);

  const responses = await Promise.all(
    languageValues.map((language) =>
      fetchPublicTrainingGroups({ locale, language }),
    ),
  );

  const merged = responses.flatMap((response) => response.groups);

  return filterJoinableTrainingGroupsForLocale(merged, locale);
}
