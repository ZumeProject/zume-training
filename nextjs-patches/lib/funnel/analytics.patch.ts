/**
 * Export the shared Ads conversion helper used by signup/coach so join-training
 * can reuse the same sessionStorage dedupe (`zume-ads-conversion:{send_to}`).
 *
 * In lib/funnel/analytics.ts, export:
 *
 *   export function emitFunnelAdsConversion(
 *     sendTo: string,
 *     options?: { gtag?: Gtag; storage?: Storage | null },
 *   ) { ... existing internal N() helper ... }
 *
 * Signup uses:  AW-16678073167/PEDMCNGsgMwZEM_m3JA-
 * Coach uses:    AW-16678073167/XNCdCMzCyssaEM_m3JA-
 * Join-training: NEXT_PUBLIC_JOIN_TRAINING_ADS_CONVERSION_SEND_TO (set after deploy)
 */
