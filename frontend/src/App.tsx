import { Route, Routes, Navigate } from 'react-router-dom';
import PublicHomePage from './pages/PublicHomePage';
import PublicPrayersPage from './pages/PublicPrayersPage';
import PublicLecturesPage from './pages/PublicLecturesPage';
import PublicEventsPage from './pages/PublicEventsPage';
import PublicCampaignsPage from './pages/PublicCampaignsPage';
import PublicDonatePage from './pages/PublicDonatePage';
import PublicWhatsAppSubscribePage from './pages/PublicWhatsAppSubscribePage';
import PublicWhatsAppUnsubscribePage from './pages/PublicWhatsAppUnsubscribePage';
import TenantLoginPage from './pages/TenantLoginPage';
import TenantDashboardPage from './pages/TenantDashboardPage';
import TenantContentPage from './pages/TenantContentPage';
import PlatformLoginPage from './pages/PlatformLoginPage';
import PlatformDashboardPage from './pages/PlatformDashboardPage';
import PlatformMosquesPage from './pages/PlatformMosquesPage';
import PlatformPlansPage from './pages/PlatformPlansPage';
import PlatformSubscriptionsPage from './pages/PlatformSubscriptionsPage';
import PlatformOverridesPage from './pages/PlatformOverridesPage';
import PlatformLogsPage from './pages/PlatformLogsPage';
import NotFoundPage from './pages/NotFoundPage';

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<Navigate to="/m/al-markaz" replace />} />

      <Route path="/m/:slug" element={<PublicHomePage />} />
      <Route path="/m/:slug/prayers" element={<PublicPrayersPage />} />
      <Route path="/m/:slug/lectures" element={<PublicLecturesPage />} />
      <Route path="/m/:slug/events" element={<PublicEventsPage />} />
      <Route path="/m/:slug/campaigns" element={<PublicCampaignsPage />} />
      <Route path="/m/:slug/donate" element={<PublicDonatePage />} />
      <Route path="/m/:slug/whatsapp/subscribe" element={<PublicWhatsAppSubscribePage />} />
      <Route path="/m/:slug/whatsapp/unsubscribe" element={<PublicWhatsAppUnsubscribePage />} />

      <Route path="/admin/:slug/login" element={<TenantLoginPage />} />
      <Route path="/admin/:slug/dashboard" element={<TenantDashboardPage />} />
      <Route path="/admin/:slug/content" element={<TenantContentPage />} />

      <Route path="/platform-admin/login" element={<PlatformLoginPage />} />
      <Route path="/platform-admin/dashboard" element={<PlatformDashboardPage />} />
      <Route path="/platform-admin/mosques" element={<PlatformMosquesPage />} />
      <Route path="/platform-admin/plans" element={<PlatformPlansPage />} />
      <Route path="/platform-admin/subscriptions" element={<PlatformSubscriptionsPage />} />
      <Route path="/platform-admin/overrides" element={<PlatformOverridesPage />} />
      <Route path="/platform-admin/logs" element={<PlatformLogsPage />} />

      <Route path="*" element={<NotFoundPage />} />
    </Routes>
  );
}
