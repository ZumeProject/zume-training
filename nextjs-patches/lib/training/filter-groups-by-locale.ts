import { languages } from "@/lib/i18n/languages";

export type PublicTrainingGroup = {
  id: number;
  public_id: string;
  name: string;
  language?: string | null;
};

function normalizeToken(value: string): string {
  return value
    .trim()
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "");
}

function localeLanguageTokens(locale: string): string[] {
  const tokens = new Set<string>();
  const normalizedLocale = normalizeToken(locale);

  tokens.add(normalizedLocale);

  const config = languages[locale];
  if (config?.name) tokens.add(normalizeToken(config.name));
  if (config?.nativeName) tokens.add(normalizeToken(config.nativeName));
  if (config?.locale) tokens.add(normalizeToken(config.locale));
  if (config?.weblateCode) tokens.add(normalizeToken(config.weblateCode));

  if (normalizedLocale === "en") {
    tokens.add("english");
  }
  if (normalizedLocale === "es") {
    tokens.add("spanish");
    tokens.add("espanol");
  }

  return [...tokens].filter(Boolean);
}

function groupLanguageTokens(language: string): string[] {
  const normalized = normalizeToken(language);
  const tokens = new Set<string>([normalized]);

  if (normalized === "english") tokens.add("en");
  if (normalized === "espanol" || normalized === "spanish") tokens.add("es");

  return [...tokens];
}

export function groupMatchesPageLocale(
  group: PublicTrainingGroup,
  locale: string,
): boolean {
  const groupLanguage = group.language?.trim();
  if (!groupLanguage) {
    return false;
  }

  const localeTokens = localeLanguageTokens(locale);
  const trainingTokens = groupLanguageTokens(groupLanguage);

  return trainingTokens.some((trainingToken) =>
    localeTokens.some(
      (localeToken) =>
        trainingToken === localeToken ||
        trainingToken.startsWith(`${localeToken}-`) ||
        localeToken.startsWith(`${trainingToken}-`),
    ),
  );
}

export function filterGroupsByPageLocale<T extends PublicTrainingGroup>(
  groups: T[],
  locale: string,
): T[] {
  return groups.filter((group) => groupMatchesPageLocale(group, locale));
}
