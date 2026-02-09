import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';
import ActionCard from '../components/ActionCard';

interface Lecture {
  id: number;
  title: string;
  type: string;
  speaker?: { name: string };
}

export default function PublicLecturesPage() {
  const { slug = '' } = useParams();
  const [lectures, setLectures] = useState<Lecture[]>([]);
  const [loading, setLoading] = useState(false);

  const loadLectures = () => {
    setLoading(true);
    api.get(`/api/public/mosques/${slug}/lectures`)
      .then((response) => setLectures(response.data.data))
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    loadLectures();
  }, [slug]);

  return (
    <PageShell title="المحاضرات" backLink={`/m/${slug}`}>
      <ActionCard title="قائمة المحاضرات" description="تحديث مباشر للمحتوى المنشور.">
        <button
          onClick={loadLectures}
          className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm"
          disabled={loading}
        >
          {loading ? 'جارٍ التحديث...' : 'تحديث القائمة'}
        </button>
      </ActionCard>
      <div className="mt-4 space-y-3">
        {lectures.map((lecture) => (
          <div key={lecture.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <h3 className="font-semibold">{lecture.title}</h3>
            <p className="text-sm text-slate-500">{lecture.speaker?.name ?? 'متحدث غير محدد'} · {lecture.type}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
