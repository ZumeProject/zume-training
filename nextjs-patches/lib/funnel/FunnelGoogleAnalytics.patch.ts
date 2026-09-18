/**
 * Add join-training listener alongside existing signup/coach listeners in
 * FunnelGoogleAnalytics (consent-gated gtag, same pattern as /go).
 *
 * Existing:
 *   zume-funnel-signup-completed  → emitFunnelSignupCompletedTracking
 *   zume-funnel-coach-submitted   → emitFunnelCoachSubmittedTracking
 *
 * Add:
 *   zume-funnel-join-training-completed → emitFunnelJoinTrainingCompletedTracking
 *
 * reportFunnelJoinTrainingCompleted() dispatches the DOM event; the analytics
 * component listener calls emitFunnelJoinTrainingCompletedTracking (same split as
 * reportFunnelSignupCompleted / reportFunnelCoachSubmitted).
 */
