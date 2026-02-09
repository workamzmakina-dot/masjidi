import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

interface Campaign {
  id: number;
  title: string;
}

export default function PublicDonatePage() {
  const { slug = '' } = useParams();
  const [campaigns, setCampaigns] = useState<Campaign[]>([]);
  const [campaignId, setCampaignId] = useState('');
  const [amount, setAmount] = useState('50');
  const [status, setStatus] = useState<string | null>(null);

  useEffect(() => {
    api.get(`/api/public/mosques/${slug}/campaigns`).then((response) => {
      setCampaigns(response.data.data);
      if (response.data.data.length > 0) {
        setCampaignId(String(response.data.data[0].id));
      }
    });
  }, [slug]);

  const submitDonation = async () => {
    setStatus('جارٍ إنشاء عملية التبرع...');
    try {
      const response = await api.post(`/api/public/mosques/${slug}/donations`, {
        campaign_id: Number(campaignId),
        amount: Number(amount),
        currency: 'USD',
        donor_name: 'متبرع كريم',
      });
      setStatus(`تم إنشاء التبرع. رابط الدفع: ${response.data.checkout_url ?? 'سيتم التواصل لاحقاً'}`);
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إنشاء التبرع');
    }
  };

  return (
    <PageShell title="التبرعات" backLink={`/m/${slug}`}>
      <ActionCard title="تبرع عبر Wish Money" description="اختر الحملة وحدد المبلغ لتوليد رابط الدفع.">
        <div className="grid gap-3">
          <select
            className="border border-slate-200 rounded-xl px-3 py-2 text-sm"
            value={campaignId}
            onChange={(event) => setCampaignId(event.target.value)}
          >
            {campaigns.map((campaign) => (
              <option key={campaign.id} value={campaign.id}>
                {campaign.title}
              </option>
            ))}
          </select>
          <input
            className="border border-slate-200 rounded-xl px-3 py-2 text-sm"
            value={amount}
            onChange={(event) => setAmount(event.target.value)}
            type="number"
            min={1}
          />
          <button onClick={submitDonation} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إنشاء عملية التبرع
          </button>
          {status ? <p className="text-xs text-slate-600">{status}</p> : null}
        </div>
      </ActionCard>
    </PageShell>
  );
}
