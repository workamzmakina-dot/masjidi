import { useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

export default function TenantContentPage() {
  const { slug = '' } = useParams();
  const [status, setStatus] = useState<string | null>(null);

  const headers = { 'X-Tenant-Slug': slug };

  const createLecture = async () => {
    setStatus('جارٍ إنشاء محاضر ومحاضرة...');
    try {
      const speaker = await api.post('/api/tenant/speakers', { name: 'ضيف الأسبوع' }, { headers });
      await api.post(
        '/api/tenant/lectures',
        { speaker_id: speaker.data.id, title: 'محاضرة تجريبية', type: 'video' },
        { headers },
      );
      setStatus('تمت إضافة المحاضرة.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إنشاء المحاضرة.');
    }
  };

  const createEvent = async () => {
    setStatus('جارٍ إنشاء فعالية...');
    try {
      await api.post(
        '/api/tenant/events',
        {
          title: 'فعالية مجتمعية',
          description: 'فعالية أسبوعية لتعزيز الترابط.',
          start_at: new Date().toISOString(),
        },
        { headers },
      );
      setStatus('تمت إضافة الفعالية.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إنشاء الفعالية.');
    }
  };

  const createCampaign = async () => {
    setStatus('جارٍ إنشاء حملة تبرعات...');
    try {
      await api.post(
        '/api/tenant/campaigns',
        { title: 'حملة الصيانة', description: 'دعم أعمال الصيانة الدورية.', goal_amount: 10000 },
        { headers },
      );
      setStatus('تمت إضافة الحملة.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إنشاء الحملة.');
    }
  };

  const createAlert = async () => {
    setStatus('جارٍ إرسال تنبيه...');
    try {
      await api.post(
        '/api/tenant/alerts',
        {
          message: 'سيتم إغلاق القاعة بعد العشاء للصيانة.',
          type: 'info',
          starts_at: new Date().toISOString(),
          ends_at: new Date(Date.now() + 86400000).toISOString(),
        },
        { headers },
      );
      setStatus('تم إرسال التنبيه.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إرسال التنبيه.');
    }
  };

  const createTemplate = async () => {
    setStatus('جارٍ إنشاء قالب واتساب...');
    try {
      await api.post(
        '/api/tenant/whatsapp/templates',
        { name: 'تحديث أسبوعي', language: 'ar', content: 'السلام عليكم، هذا تحديث الأسبوع.' },
        { headers },
      );
      setStatus('تم إنشاء القالب.');
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر إنشاء القالب.');
    }
  };

  return (
    <PageShell title="إدارة المحتوى" backLink={`/admin/${slug}/dashboard`}>
      <div className="grid gap-4">
        <ActionCard title="المحاضرات" description="إضافة محتوى تعليمي جديد.">
          <button onClick={createLecture} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إضافة محاضرة
          </button>
        </ActionCard>
        <ActionCard title="الفعاليات" description="جدولة فعالية مجتمعية.">
          <button onClick={createEvent} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إضافة فعالية
          </button>
        </ActionCard>
        <ActionCard title="الحملات" description="فتح حملة تبرعات جديدة.">
          <button onClick={createCampaign} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إضافة حملة
          </button>
        </ActionCard>
        <ActionCard title="التنبيهات" description="إرسال تنبيه للمصلين.">
          <button onClick={createAlert} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إرسال تنبيه
          </button>
        </ActionCard>
        <ActionCard title="واتساب" description="إنشاء قالب جاهز للبث.">
          <button onClick={createTemplate} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
            إنشاء قالب
          </button>
        </ActionCard>
        {status ? <p className="text-xs text-slate-600">{status}</p> : null}
      </div>
    </PageShell>
  );
}
