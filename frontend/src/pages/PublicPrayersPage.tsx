import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface PrayerSettings {
  method: string;
  timezone: string;
  iqama_offsets?: Record<string, number>;
}

export default function PublicPrayersPage() {
  const { slug = '' } = useParams();
  const [settings, setSettings] = useState<PrayerSettings | null>(null);

  useEffect(() => {
    api.get(`/api/public/mosques/${slug}/prayers`).then((response) => setSettings(response.data.settings));
  }, [slug]);

  return (
    <PageShell title="مواقيت الصلاة" backLink={`/m/${slug}`}>
      <div className="bg-white rounded-2xl border border-slate-200 p-5 space-y-3">
        <p className="text-sm text-slate-600">طريقة الحساب: {settings?.method ?? 'غير محدد'}</p>
        <p className="text-sm text-slate-600">المنطقة الزمنية: {settings?.timezone ?? 'غير محدد'}</p>
        <div className="text-sm text-slate-700">
          {settings?.iqama_offsets ? (
            <ul className="space-y-1">
              {Object.entries(settings.iqama_offsets).map(([name, value]) => (
                <li key={name} className="flex justify-between">
                  <span>{name}</span>
                  <span>{value} دقيقة</span>
                </li>
              ))}
            </ul>
          ) : (
            <p>لا توجد فروقات إقامة محفوظة.</p>
          )}
        </div>
        <Link className="text-emerald-600 text-sm" to={`/m/${slug}/donate`}>
          ساهم في دعم المسجد
        </Link>
      </div>
    </PageShell>
  );
}
