import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface Campaign {
  id: number;
  title: string;
  description: string;
  goal_amount?: number;
  current_amount?: number;
}

export default function PublicCampaignsPage() {
  const { slug = '' } = useParams();
  const [campaigns, setCampaigns] = useState<Campaign[]>([]);

  useEffect(() => {
    api.get(`/api/public/mosques/${slug}/campaigns`).then((response) => setCampaigns(response.data.data));
  }, [slug]);

  return (
    <PageShell title="الحملات" backLink={`/m/${slug}`}>
      <div className="space-y-3">
        {campaigns.map((campaign) => (
          <div key={campaign.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <h3 className="font-semibold">{campaign.title}</h3>
            <p className="text-sm text-slate-600 mt-2">{campaign.description}</p>
            <p className="text-xs text-slate-500 mt-2">
              {campaign.current_amount ?? 0} / {campaign.goal_amount ?? 0} USD
            </p>
            <Link className="text-emerald-600 text-sm mt-2 inline-block" to={`/m/${slug}/donate`}>
              ساهم الآن
            </Link>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
