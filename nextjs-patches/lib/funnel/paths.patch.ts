/**
 * Apply these changes to the existing funnel path helpers (production: isParentChromeHiddenPath).
 *
 * /join must hide global marketing chrome, same as /go.
 */

// Before:
// export function isGoFunnelPath(pathname: string): boolean {
//   return removeLocalePrefix(pathname) === "/go";
// }

// After:
export function isGoFunnelPath(pathname: string): boolean {
  const path = removeLocalePrefix(pathname);
  return path === "/go" || path === "/join";
}

// Before:
// export function isParentChromeHiddenPath(pathname: string): boolean {
//   const parts = removeLocalePrefix(pathname).split("/").filter(Boolean);
//   return (
//     (parts.length === 2 && parts[0] === "articles" && parts[1].length > 0) ||
//     isGoFunnelPath(pathname) ||
//     isFunnelPrivacyPath(pathname)
//   );
// }

// After: include /join via isGoFunnelPath (or add explicit check for path === "/join").
