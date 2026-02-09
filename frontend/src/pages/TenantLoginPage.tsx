import { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api, { getCsrfCookie } from '../lib/api';
import PageShell from '../components/PageShell';
import { setTenantSession } from '../lib/session';

export default function TenantLoginPage() {
  const { slug = '' } = useParams();
  const navigate = useNavigate();
  const [email, setEmail] = useState('admin@al-markaz.org');
  const [password, setPassword] = useState('password');
  const [status, setStatus] = useState<string | null>(null);

  const submit = async () => {
    setStatus('جارٍ تسجيل الدخول...');
    try {
      await getCsrfCookie();
      await api.post('/api/auth/login', {
        email,
        password,
        role: 'tenant',
        mosque_slug: slug,
      });
      setTenantSession(slug, email);
      navigate(`/admin/${slug}/dashboard`);
    } catch (error: any) {
      setStatus(error?.response?.data?.message ?? 'تعذر تسجيل الدخول.');
    }
  };

  return (
    <PageShell title="تسجيل دخول إدارة المسجد" backLink={`/m/${slug}`}>
      <div className="bg-white border border-slate-200 rounded-2xl p-5 space-y-3">
        <input
          className="border border-slate-200 rounded-xl px-3 py-2 text-sm w-full"
          value={email}
          onChange={(event) => setEmail(event.target.value)}
          placeholder="البريد الإلكتروني"
        />
        <input
          type="password"
          className="border border-slate-200 rounded-xl px-3 py-2 text-sm w-full"
          value={password}
          onChange={(event) => setPassword(event.target.value)}
          placeholder="كلمة المرور"
        />
        <button onClick={submit} className="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm">
          تسجيل الدخول
        </button>
        {status ? <p className="text-xs text-slate-600">{status}</p> : null}
      </div>
    </PageShell>
  );
}
