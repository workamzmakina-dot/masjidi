import { useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

export default function PublicWhatsAppSubscribePage() {
  const { slug = '' } = useParams();
  const [phone, setPhone] = useState('');
  const [status, setStatus] = useState<string | null>(null);

  const submit = async () => {
    setStatus('جارٍ الاشتراك...');
    try {
      await api.post(`/api/public/mosques/${slug}/whatsapp/subscribe`, { phone_e164: phone });
      setStatus('تم الاشتراك بنجاح.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر الاشتراك.');
    }
  };

  return (
    <PageShell title="الاشتراك في واتساب" backLink={`/m/${slug}`}>
      <div className="bg-white border border-slate-200 rounded-2xl p-5 space-y-3">
        <input
          className="border border-slate-200 rounded-xl px-3 py-2 text-sm w-full"
          placeholder="رقم الهاتف بصيغة دولية"
          value={phone}
          onChange={(event) => setPhone(event.target.value)}
        />
        <button onClick={submit} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
          اشتراك
        </button>
        {status ? <p className="text-xs text-slate-600">{status}</p> : null}
      </div>
    </PageShell>
  );
}
