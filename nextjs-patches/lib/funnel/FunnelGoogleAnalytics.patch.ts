/**
 * Add join-training conversion listener alongside existing signup/coach listeners.
 */

import {
  FUNNEL_CONVERSION_DOM_EVENT,
  FUNNEL_SIGNUP_DOM_EVENT,
  emitFunnelCoachSubmittedTracking,
  emitFunnelSignupCompletedTracking,
  getFunnelGaMeasurementId,
  getFunnelSessionStorage,
  shouldInjectFunnelGtag,
} from "@/lib/funnel/analytics";
import {
  FUNNEL_JOIN_TRAINING_DOM_EVENT,
  emitFunnelJoinTrainingCompletedTracking,
} from "@/lib/funnel/analytics-join-training";

// Inside FunnelGoogleAnalytics useEffect:
//
// const onJoinTraining = () => {
//   emitFunnelJoinTrainingCompletedTracking({
//     gtag: window.gtag,
//     storage: getFunnelSessionStorage(),
//   });
// };
//
// window.addEventListener(FUNNEL_CONVERSION_DOM_EVENT, onCoachSubmitted);
// window.addEventListener(FUNNEL_SIGNUP_DOM_EVENT, onSignupCompleted);
// window.addEventListener(FUNNEL_JOIN_TRAINING_DOM_EVENT, onJoinTraining);
//
// return () => {
//   window.removeEventListener(FUNNEL_CONVERSION_DOM_EVENT, onCoachSubmitted);
//   window.removeEventListener(FUNNEL_SIGNUP_DOM_EVENT, onSignupCompleted);
//   window.removeEventListener(FUNNEL_JOIN_TRAINING_DOM_EVENT, onJoinTraining);
// };
