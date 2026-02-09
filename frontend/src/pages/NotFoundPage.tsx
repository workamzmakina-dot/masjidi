import { Link } from 'react-router-dom';
import PageShell from '../components/PageShell';

export default function NotFoundPage() {
  return (
    <PageShell title="الصفحة غير موجودة">
      <div className="bg-white border border-slate-200 rounded-2xl p-5 space-y-3">
        <p className="text-sm text-slate-600">تعذر العثور على الصفحة المطلوبة.</p>
        <Link className="text-emerald-600 text-sm" to="/m/al-markaz">
          العودة إلى الموقع العام
        </Link>
      </div>
    </PageShell>
  );
}
