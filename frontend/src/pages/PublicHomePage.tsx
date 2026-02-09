import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface MosqueResponse {
  mosque: {
    name: string;
    slug: string;
    settings: Record<string, string> | null;
  };
}

export default function PublicHomePage() {
  const { slug = '' } = useParams();
  const [data, setData] = useState<MosqueResponse | null>(null);

  useEffect(() => {
    api.get(`/api/public/mosques/${slug}`).then((response) => setData(response.data));
  }, [slug]);

  return (
    <PageShell title={data?.mosque.name ?? 'المسجد'}>
      <div className="space-y-6">
        <section className="bg-emerald-600 text-white rounded-3xl p-6">
          <h2 className="text-xl font-bold">مرحبا بكم في {data?.mosque.name ?? 'مسجدنا'}</h2>
          <p className="text-sm mt-2 text-emerald-100">
            منصة متكاملة لإدارة الأنشطة والتبرعات والتواصل مع المجتمع.
          </p>
          <div className="mt-4 flex flex-wrap gap-3">
            <Link className="bg-white text-emerald-700 px-4 py-2 rounded-full text-sm" to={`/m/${slug}/donate`}>
              تبرع الآن
            </Link>
            <Link className="bg-emerald-700 text-white px-4 py-2 rounded-full text-sm" to={`/m/${slug}/lectures`}>
              محاضرات اليوم
            </Link>
          </div>
        </section>

        <section className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <Link className="bg-white rounded-2xl p-4 border border-slate-200" to={`/m/${slug}/prayers`}>
            مواقيت الصلاة
          </Link>
          <Link className="bg-white rounded-2xl p-4 border border-slate-200" to={`/m/${slug}/events`}>
            الفعاليات القادمة
          </Link>
          <Link className="bg-white rounded-2xl p-4 border border-slate-200" to={`/m/${slug}/campaigns`}>
            حملات الدعم
          </Link>
          <Link className="bg-white rounded-2xl p-4 border border-slate-200" to={`/m/${slug}/whatsapp/subscribe`}>
            الاشتراك في واتساب
          </Link>
        </section>
      </div>
    </PageShell>
  );
}
