import { useEffect, useState } from 'react';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

interface Feature {
  id: number;
  name: string;
  display_name: string;
}

interface Mosque {
  id: number;
  name: string;
}

interface Override {
  id: number;
  mosque: Mosque;
  feature: Feature;
  enabled: boolean;
}

export default function PlatformOverridesPage() {
  const [overrides, setOverrides] = useState<Override[]>([]);
  const [features, setFeatures] = useState<Feature[]>([]);
  const [mosques, setMosques] = useState<Mosque[]>([]);
  const [mosqueId, setMosqueId] = useState('');
  const [featureId, setFeatureId] = useState('');

  const load = async () => {
    const [overrideRes, featureRes, mosqueRes] = await Promise.all([
      api.get('/api/platform/feature-overrides'),
      api.get('/api/platform/features'),
      api.get('/api/platform/mosques'),
    ]);
    setOverrides(overrideRes.data.data);
    setFeatures(featureRes.data);
    setMosques(mosqueRes.data.data);
    if (mosqueRes.data.data.length > 0) setMosqueId(String(mosqueRes.data.data[0].id));
    if (featureRes.data.length > 0) setFeatureId(String(featureRes.data[0].id));
  };

  useEffect(() => {
    load();
  }, []);

  const createOverride = async () => {
    await api.post('/api/platform/feature-overrides', {
      mosque_id: Number(mosqueId),
      feature_id: Number(featureId),
      enabled: true,
    });
    await load();
  };

  return (
    <PageShell title="تجاوزات الميزات">
      <ActionCard title="إضافة تجاوز" description="تفعيل ميزة لمسجد محدد بشكل استثنائي.">
        <div className="grid gap-2">
          <select className="border border-slate-200 rounded-xl px-3 py-2 text-sm" value={mosqueId} onChange={(e) => setMosqueId(e.target.value)}>
            {mosques.map((mosque) => (
              <option key={mosque.id} value={mosque.id}>
                {mosque.name}
              </option>
            ))}
          </select>
          <select className="border border-slate-200 rounded-xl px-3 py-2 text-sm" value={featureId} onChange={(e) => setFeatureId(e.target.value)}>
            {features.map((feature) => (
              <option key={feature.id} value={feature.id}>
                {feature.display_name}
              </option>
            ))}
          </select>
          <button onClick={createOverride} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إنشاء تجاوز
          </button>
        </div>
      </ActionCard>

      <div className="mt-4 space-y-3">
        {overrides.map((override) => (
          <div key={override.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="font-semibold">{override.mosque?.name}</p>
            <p className="text-xs text-slate-500">{override.feature?.display_name} · {override.enabled ? 'مفعل' : 'معطل'}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
