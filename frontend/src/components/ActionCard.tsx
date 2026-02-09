import { ReactNode } from 'react';

interface ActionCardProps {
  title: string;
  description: string;
  children: ReactNode;
}

export default function ActionCard({ title, description, children }: ActionCardProps) {
  return (
    <div className="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-3">
      <div>
        <h2 className="text-base font-semibold text-slate-900">{title}</h2>
        <p className="text-sm text-slate-500">{description}</p>
      </div>
      {children}
    </div>
  );
}
