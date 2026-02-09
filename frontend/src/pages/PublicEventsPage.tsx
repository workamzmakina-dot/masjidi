import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../lib/api';
import PageShell from '../components/PageShell';

interface EventItem {
  id: number;
  title: string;
  description: string;
  start_at: string;
}

export default function PublicEventsPage() {
  const { slug = '' } = useParams();
  const [events, setEvents] = useState<EventItem[]>([]);

  useEffect(() => {
    api.get(`/api/public/mosques/${slug}/events`).then((response) => setEvents(response.data.data));
  }, [slug]);

  return (
    <PageShell title="الفعاليات" backLink={`/m/${slug}`}>
      <div className="space-y-3">
        {events.map((event) => (
          <div key={event.id} className="bg-white border border-slate-200 rounded-2xl p-4">
            <h3 className="font-semibold">{event.title}</h3>
            <p className="text-sm text-slate-500">{new Date(event.start_at).toLocaleString('ar')}</p>
            <p className="text-sm text-slate-600 mt-2">{event.description}</p>
          </div>
        ))}
      </div>
    </PageShell>
  );
}
