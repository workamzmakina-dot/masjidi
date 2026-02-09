import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface Metrics {
  donation_total: number;
  active_campaigns: number;
  upcoming_events: number;
  whatsapp_subscribers: number;
}

export default function TenantDashboardPage() {
  const { slug = '' } = useParams();
  const [metrics, setMetrics] = useState<Metrics | null>(null);

  const loadDashboard = () => {
    api
      .get('/api/tenant/dashboard', { headers: { 'X-Tenant-Slug': slug } })
      .then((response) => setMetrics(response.data.metrics));
  };

  useEffect(() => {
    loadDashboard();
  }, [slug]);

  return (
    <PageShell title="لوحة إدارة المسجد" backLink={`/m/${slug}`}>
      <div className="space-y-4">
        <button onClick={loadDashboard} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
          تحديث البيانات
        </button>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="text-xs text-slate-500">إجمالي التبرعات</p>
            <p className="text-xl font-bold">${metrics?.donation_total ?? 0}</p>
          </div>
          <div className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="text-xs text-slate-500">حملات نشطة</p>
            <p className="text-xl font-bold">{metrics?.active_campaigns ?? 0}</p>
          </div>
          <div className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="text-xs text-slate-500">فعاليات قادمة</p>
            <p className="text-xl font-bold">{metrics?.upcoming_events ?? 0}</p>
          </div>
          <div className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="text-xs text-slate-500">مشتركو واتساب</p>
            <p className="text-xl font-bold">{metrics?.whatsapp_subscribers ?? 0}</p>
          </div>
        </div>
        <Link className="text-emerald-600 text-sm" to={`/admin/${slug}/content`}>
          إدارة المحتوى
        </Link>
      </div>
    </PageShell>
  );
}
