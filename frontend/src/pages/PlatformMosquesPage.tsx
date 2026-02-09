import { useEffect, useState } from 'react';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

interface Mosque {
  id: number;
  name: string;
  slug: string;
  status: string;
}

export default function PlatformMosquesPage() {
  const [mosques, setMosques] = useState<Mosque[]>([]);
  const [plans, setPlans] = useState<any[]>([]);
  const [name, setName] = useState('مسجد جديد');
  const [slug, setSlug] = useState('new-mosque');
  const [planId, setPlanId] = useState('');

  const load = async () => {
    const [mosqueRes, planRes] = await Promise.all([
      api.get('/api/platform/mosques'),
      api.get('/api/platform/plans'),
    ]);
    setMosques(mosqueRes.data.data);
    setPlans(planRes.data.data);
    if (planRes.data.data.length > 0) {
      setPlanId(String(planRes.data.data[0].id));
    }
  };

  useEffect(() => {
    load();
  }, []);

  const createMosque = async () => {
    await api.post('/api/platform/mosques', {
      name,
      slug,
      plan_id: Number(planId),
      status: 'active',
    });
    await load();
  };

  return (
    <PageShell title="المساجد">
      <ActionCard title="إضافة مسجد" description="إنشاء مستأجر جديد في المنصة.">
        <div className="grid gap-2">
          <input
            className="border border-slate-200 rounded-xl px-3 py-2 text-sm"
            value={name}
            onChange={(event) => setName(event.target.value)}
            placeholder="اسم المسجد"
          />
          <input
            className="border border-slate-200 rounded-xl px-3 py-2 text-sm"
            value={slug}
            onChange={(event) => setSlug(event.target.value)}
            placeholder="الرابط التعريفي"
          />
          <select
            className="border border-slate-200 rounded-xl px-3 py-2 text-sm"
            value={planId}
            onChange={(event) => setPlanId(event.target.value)}
          >
            {plans.map((plan) => (
              <option key={plan.id} value={plan.id}>
                {plan.name}
              </option>
            ))}
          </select>
          <button onClick={createMosque} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إنشاء المسجد
          </button>
        </div>
      </ActionCard>

      <div className="mt-4 space-y-3">
        {mosques.map((mosque) => (
          <div key={mosque.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="font-semibold">{mosque.name}</p>
            <p className="text-xs text-slate-500">/{mosque.slug} · {mosque.status}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
