import { ReactNode } from 'react';
import { Link } from 'react-router-dom';

interface PageShellProps {
  title: string;
  children: ReactNode;
  backLink?: string;
}

export default function PageShell({ title, children, backLink }: PageShellProps) {
  return (
    <div className="min-h-screen bg-slate-50">
      <header className="bg-white shadow-sm border-b">
        <div className="mx-auto max-w-5xl px-4 py-4 flex items-center justify-between">
          <div className="flex items-center gap-3">
            {backLink ? (
              <Link className="text-emerald-600 text-sm" to={backLink}>
                رجوع
              </Link>
            ) : null}
            <h1 className="text-lg font-bold text-slate-900">{title}</h1>
          </div>
          <span className="text-xs text-slate-500">منصة المساجد متعددة المستأجرين</span>
        </div>
      </header>
      <main className="mx-auto max-w-5xl px-4 py-6">{children}</main>
    </div>
  );
}
