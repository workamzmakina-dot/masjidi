import { useEffect, useState } from 'react';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

interface Plan {
  id: number;
  name: string;
  slug: string;
  price_monthly: number;
}

export default function PlatformPlansPage() {
  const [plans, setPlans] = useState<Plan[]>([]);
  const [name, setName] = useState('خطة جديدة');
  const [slug, setSlug] = useState('new-plan');
  const [price, setPrice] = useState('49');

  const load = async () => {
    const response = await api.get('/api/platform/plans');
    setPlans(response.data.data);
  };

  useEffect(() => {
    load();
  }, []);

  const createPlan = async () => {
    await api.post('/api/platform/plans', {
      name,
      slug,
      price_monthly: Number(price),
    });
    await load();
  };

  return (
    <PageShell title="الخطط">
      <ActionCard title="إنشاء خطة" description="إضافة خطة اشتراك جديدة.">
        <div className="grid gap-2">
          <input className="border border-slate-200 rounded-xl px-3 py-2 text-sm" value={name} onChange={(e) => setName(e.target.value)} />
          <input className="border border-slate-200 rounded-xl px-3 py-2 text-sm" value={slug} onChange={(e) => setSlug(e.target.value)} />
          <input className="border border-slate-200 rounded-xl px-3 py-2 text-sm" value={price} onChange={(e) => setPrice(e.target.value)} type="number" />
          <button onClick={createPlan} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            حفظ الخطة
          </button>
        </div>
      </ActionCard>

      <div className="mt-4 space-y-3">
        {plans.map((plan) => (
          <div key={plan.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="font-semibold">{plan.name}</p>
            <p className="text-xs text-slate-500">{plan.slug} · ${plan.price_monthly}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
