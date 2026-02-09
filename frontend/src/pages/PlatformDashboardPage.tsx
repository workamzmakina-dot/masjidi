import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface MosqueItem {
  id: number;
}

export default function PlatformDashboardPage() {
  const [count, setCount] = useState(0);

  const load = () => {
    api.get('/api/platform/mosques').then((response) => setCount(response.data.total));
  };

  useEffect(() => {
    load();
  }, []);

  return (
    <PageShell title="لوحة إدارة المنصة">
      <div className="space-y-4">
        <button onClick={load} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
          تحديث عدد المساجد
        </button>
        <div className="bg-white border border-slate-200 rounded-2xl p-4">
          <p className="text-xs text-slate-500">عدد المساجد المسجلة</p>
          <p className="text-2xl font-bold">{count}</p>
        </div>
        <div className="grid grid-cols-2 gap-3 text-sm">
          <Link className="text-emerald-600" to="/platform-admin/mosques">
            إدارة المساجد
          </Link>
          <Link className="text-emerald-600" to="/platform-admin/plans">
            إدارة الخطط
          </Link>
          <Link className="text-emerald-600" to="/platform-admin/subscriptions">
            الاشتراكات
          </Link>
          <Link className="text-emerald-600" to="/platform-admin/logs">
            السجلات
          </Link>
        </div>
      </div>
    </PageShell>
  );
}
