import { useEffect, useState } from 'react';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface LogItem {
  id: number;
  event: string;
  created_at: string;
  user_type: string;
}

export default function PlatformLogsPage() {
  const [logs, setLogs] = useState<LogItem[]>([]);

  useEffect(() => {
    api.get('/api/platform/audit-logs').then((response) => setLogs(response.data.data));
  }, []);

  return (
    <PageShell title="سجلات التدقيق">
      <div className="space-y-3">
        {logs.map((log) => (
          <div key={log.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <p className="font-semibold">{log.event}</p>
            <p className="text-xs text-slate-500">{log.user_type} · {new Date(log.created_at).toLocaleString('ar')}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
