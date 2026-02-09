import { useEffect, useState } from 'react';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface Subscription {
  id: number;
  mosque: { name: string };
  plan: { name: string };
}

export default function PlatformSubscriptionsPage() {
  const [subscriptions, setSubscriptions] = useState<Subscription[]>([]);

  useEffect(() => {
    api.get('/api/platform/subscriptions').then((response) => setSubscriptions(response.data.data));
  }, []);

  return (
    <PageShell title="الاشتراكات">
      <div className="space-y-3">
        {subscriptions.map((subscription) => (
          <div key={subscription.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="font-semibold">{subscription.mosque?.name}</p>
            <p className="text-xs text-slate-500">{subscription.plan?.name}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
