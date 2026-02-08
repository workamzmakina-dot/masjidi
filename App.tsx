
import React, { useState } from 'react';
import { DocTab, SchemaTable, IndexExplanation } from './types';
import { SCHEMA_TABLES, IMPORTANT_INDEXES, MODULE_CODE } from './constants';
import { 
  Database, 
  ShieldCheck, 
  Code, 
  GitBranch, 
  LayoutDashboard, 
  Search,
  CheckCircle2,
  AlertCircle,
  Globe,
  Settings,
  Lock,
  Route as RouteIcon,
  Layers,
  Clock,
  Zap,
  CreditCard,
  MessageSquare,
  Send,
  Users,
  Calendar,
  Terminal,
  Server,
  Activity,
  Box,
  ExternalLink,
  Monitor,
  ChevronRight,
  ArrowRight,
  ChevronDown,
  Info,
  LifeBuoy,
  BarChart3,
  ListTodo,
  FileText,
  AlertTriangle,
  History,
  Eye,
  Trash2,
  Ban
} from 'lucide-react';

const App: React.FC = () => {
  const [activeTab, setActiveTab] = useState<DocTab>(DocTab.OVERVIEW);
  const [activePreview, setActivePreview] = useState<'public' | 'tenant' | 'platform'>('public');

  const CodeBlock = ({ title, code, icon: Icon, lang = 'php' }: { title: string, code: string, icon: any, lang?: string }) => (
    <div className="bg-slate-900 rounded-xl overflow-hidden shadow-2xl mb-8 border border-slate-700">
      <div className="bg-slate-800 px-6 py-3 flex items-center justify-between">
        <span className="text-slate-400 text-xs font-mono flex items-center gap-2">
          <Icon size={14} /> {title}
        </span>
        <div className="flex gap-1.5">
          <div className="w-2.5 h-2.5 rounded-full bg-red-500/80"></div>
          <div className="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></div>
          <div className="w-2.5 h-2.5 rounded-full bg-green-500/80"></div>
        </div>
      </div>
      <pre className="p-6 text-indigo-300 text-[13px] overflow-x-auto font-mono leading-relaxed">
        {code}
      </pre>
    </div>
  );

  const SimulatedPublicSite = () => (
    <div className="bg-gray-50 rounded-2xl border border-slate-200 shadow-2xl overflow-hidden min-h-[600px] flex flex-col font-sans">
      <header className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
          <h1 className="text-xl font-bold text-emerald-900 flex items-center gap-2">
            <Layers className="text-emerald-600" size={20} /> Al-Markaz Mosque
          </h1>
          <nav className="flex gap-6 text-sm font-medium text-slate-600">
            <span className="text-emerald-700 border-b-2 border-emerald-700 pb-1 cursor-pointer">Home</span>
            <span className="cursor-pointer hover:text-emerald-600">Prayer Times</span>
            <span className="cursor-pointer hover:text-emerald-600">Lectures</span>
            <span className="bg-emerald-700 text-white px-4 py-1.5 rounded-full text-xs cursor-pointer hover:bg-emerald-800">Donate</span>
          </nav>
        </div>
      </header>
      <main className="flex-1 p-8 space-y-8 animate-in fade-in duration-500">
        <div className="bg-white rounded-3xl p-12 shadow-sm border border-emerald-100 text-center space-y-4">
          <h2 className="text-4xl font-black text-emerald-900 tracking-tight">Welcome to Al-Markaz</h2>
          <p className="text-slate-500 text-lg max-w-2xl mx-auto">Providing a sanctuary for faith, education, and community support in the heart of our neighborhood.</p>
          <div className="pt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 text-right" dir="rtl">
              <h3 className="font-bold text-emerald-900 mb-2">أوقات الصلاة</h3>
              <div className="text-sm space-y-2 text-emerald-800">
                <div className="flex justify-between border-b border-emerald-100 pb-1"><span>الفجر</span><span>05:30 AM</span></div>
                <div className="flex justify-between border-b border-emerald-100 pb-1"><span>الظهر</span><span>01:00 PM</span></div>
                <div className="flex justify-between"><span>العصر</span><span>04:45 PM</span></div>
              </div>
            </div>
            <div className="p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
              <h3 className="font-bold text-emerald-900 mb-2">Next Lecture</h3>
              <p className="text-sm text-emerald-800 font-medium">Tafseer Session</p>
              <p className="text-xs text-emerald-600 mt-1">Sheikh Abdullah • Today 19:30</p>
              <button className="mt-4 text-[10px] font-bold text-emerald-700 flex items-center gap-1">JOIN LIVE <ChevronRight size={10}/></button>
            </div>
            <div className="p-6 bg-emerald-700 text-white rounded-2xl shadow-lg flex flex-col justify-between">
              <div>
                <h3 className="font-bold mb-2">Renovation Project</h3>
                <div className="w-full bg-emerald-900/40 h-1.5 rounded-full mb-2 overflow-hidden">
                   <div className="bg-white h-full" style={{width: '65%'}}></div>
                </div>
                <p className="text-[10px] text-emerald-100">65% of $15,000 goal reached</p>
              </div>
              <button className="w-full bg-white text-emerald-700 text-[10px] font-bold py-2.5 rounded-xl mt-4">Donate Now</button>
            </div>
          </div>
        </div>
      </main>
    </div>
  );

  const SimulatedTenantAdmin = () => (
    <div className="bg-slate-100 rounded-2xl border border-slate-200 shadow-2xl overflow-hidden min-h-[600px] flex font-sans">
      <aside className="w-64 bg-slate-900 text-white flex flex-col">
        <div className="p-6 border-b border-slate-800">
          <h2 className="font-bold text-lg leading-tight">Al-Markaz</h2>
          <p className="text-[9px] uppercase tracking-widest text-emerald-500 font-bold">Tenant Admin Panel</p>
        </div>
        <nav className="p-4 space-y-1 flex-1">
          <div className="bg-emerald-600/10 text-emerald-500 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-3 border border-emerald-500/20">
            <LayoutDashboard size={16}/> Dashboard
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-slate-400 hover:text-white hover:bg-slate-800 transition-all cursor-pointer">
            <CreditCard size={16}/> Finance
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-slate-400 hover:text-white hover:bg-slate-800 transition-all cursor-pointer">
            <MessageSquare size={16}/> WhatsApp
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-slate-400 hover:text-white hover:bg-slate-800 transition-all cursor-pointer">
            <Users size={16}/> Members
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-slate-400 hover:text-white hover:bg-slate-800 transition-all cursor-pointer">
            <Settings size={16}/> Settings
          </div>
        </nav>
      </aside>
      <div className="flex-1 flex flex-col">
        <header className="h-14 bg-white border-b px-6 flex items-center justify-between">
          <div className="flex items-center gap-2">
            <div className="w-2 h-2 rounded-full bg-emerald-500"></div>
            <span className="text-slate-500 text-xs font-medium uppercase tracking-wider">Live System Status</span>
          </div>
          <div className="flex items-center gap-3">
             <div className="px-2 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded tracking-widest">PREMIUM</div>
             <div className="w-8 h-8 rounded-full bg-slate-200 border border-slate-300"></div>
          </div>
        </header>
        <main className="p-8 space-y-6 animate-in slide-in-from-right duration-500">
          <div className="grid grid-cols-4 gap-6">
             {[
               { label: 'Donations', val: '$4,250', color: 'text-emerald-600' },
               { label: 'Subscribers', val: '1,402', color: 'text-indigo-600' },
               { label: 'Broadcasts', val: '852', color: 'text-purple-600' },
               { label: 'Storage', val: '2.4 GB', color: 'text-amber-600' },
             ].map((s, i) => (
               <div key={i} className="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                 <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">{s.label}</p>
                 <p className={`text-2xl font-black mt-1 ${s.color}`}>{s.val}</p>
               </div>
             ))}
          </div>
          <div className="grid grid-cols-3 gap-6">
            <div className="col-span-2 bg-white rounded-3xl border border-slate-200 p-8">
              <div className="flex justify-between items-center mb-6">
                <h4 className="font-bold text-slate-800 flex items-center gap-2">
                  <Activity size={18} className="text-primary"/> Recent Activity
                </h4>
                <button className="text-[10px] font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest">See logs</button>
              </div>
              <div className="space-y-4">
                 {[
                   { t: 'Payment Received', desc: 'WISH Money Ref #9021', time: '2m ago', icon: CreditCard, c: 'bg-emerald-50 text-emerald-600' },
                   { t: 'New Subscriber', desc: '+961 71 222 333', time: '14m ago', icon: Users, c: 'bg-blue-50 text-blue-600' },
                   { t: 'Broadcast Sent', desc: 'Friday Reminder (Segment: All)', time: '1h ago', icon: Send, c: 'bg-purple-50 text-purple-600' },
                 ].map((act, i) => (
                   <div key={i} className="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-colors">
                      <div className="flex items-center gap-4">
                         <div className={`p-2 rounded-xl ${act.c}`}><act.icon size={16}/></div>
                         <div>
                            <p className="text-sm font-bold text-slate-800">{act.t}</p>
                            <p className="text-xs text-slate-500">{act.desc}</p>
                         </div>
                      </div>
                      <span className="text-[10px] text-slate-400 font-medium">{act.time}</span>
                   </div>
                 ))}
              </div>
            </div>
            <div className="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col justify-between">
              <div className="z-10">
                <h4 className="text-lg font-bold mb-2">Friday Broadcast</h4>
                <p className="text-slate-400 text-xs leading-relaxed">Automation is scheduled for this Friday at 09:00 AM. Estimated reach: 1,402 worshippers.</p>
              </div>
              <button className="z-10 bg-emerald-500 text-slate-900 font-black py-2.5 rounded-xl text-xs hover:bg-emerald-400 transition-colors">CONFIG AUTOMATION</button>
              <Zap className="absolute -right-10 -bottom-10 w-48 h-48 text-emerald-500/10" />
            </div>
          </div>
        </main>
      </div>
    </div>
  );

  const SimulatedPlatformAdmin = () => (
    <div className="bg-indigo-950 rounded-3xl border border-indigo-800 shadow-2xl overflow-hidden min-h-[600px] flex font-sans text-white">
      <aside className="w-64 bg-indigo-950 border-r border-indigo-900 flex flex-col">
        <div className="p-8 border-b border-indigo-900">
          <h2 className="text-xl font-black tracking-tight text-white flex items-center gap-2">
            <Zap className="text-emerald-400" size={20} /> SaaS Core
          </h2>
          <p className="text-[9px] uppercase text-indigo-400 font-bold tracking-widest mt-1">Platform Admin</p>
        </div>
        <nav className="p-6 space-y-1 flex-1">
          <div className="bg-indigo-900/50 text-emerald-400 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-3 border border-indigo-800">
            <BarChart3 size={16}/> Dashboard
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-indigo-300 hover:bg-indigo-900/30 transition-all cursor-pointer">
            <Globe size={16}/> Mosques
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-indigo-300 hover:bg-indigo-900/30 transition-all cursor-pointer">
            <ListTodo size={16}/> Plans
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-indigo-300 hover:bg-indigo-900/30 transition-all cursor-pointer">
            <Users size={16}/> Resellers
          </div>
          <div className="px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-3 text-indigo-300 hover:bg-indigo-900/30 transition-all cursor-pointer">
            <History size={16}/> System Logs
          </div>
        </nav>
        <div className="p-6 border-t border-indigo-900">
           <div className="flex items-center gap-3">
              <div className="w-8 h-8 rounded-full bg-indigo-800 flex items-center justify-center font-bold text-xs">S</div>
              <div>
                <p className="text-xs font-bold">Super Admin</p>
                <div className="flex items-center gap-1.5 mt-0.5">
                   <div className="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                   <span className="text-[8px] text-indigo-400 font-bold tracking-widest">ONLINE</span>
                </div>
              </div>
           </div>
        </div>
      </aside>
      <div className="flex-1 flex flex-col bg-indigo-900/10">
        <header className="h-16 border-b border-indigo-900 px-8 flex items-center justify-between bg-indigo-950/50 backdrop-blur-md">
           <div className="flex items-center gap-4">
              <span className="text-indigo-400 text-xs font-bold uppercase tracking-widest">Node: LB-ME-01</span>
              <div className="flex gap-1">
                 {[1,2,3].map(i => <div key={i} className="w-1 h-3 rounded-full bg-emerald-500/40"></div>)}
              </div>
           </div>
           <div className="flex items-center gap-6">
              <div className="flex items-center gap-2 px-3 py-1 bg-indigo-900/50 rounded-lg border border-indigo-800">
                 <Server size={12} className="text-indigo-400"/>
                 <span className="text-[10px] font-mono text-indigo-300">v11.4.2-STABLE</span>
              </div>
           </div>
        </header>
        <main className="p-10 space-y-8 overflow-y-auto">
          <div className="grid grid-cols-4 gap-6">
            {[
              { label: 'Total Revenue', val: '$12,450', change: '+12%', color: 'text-emerald-400' },
              { label: 'Active Tenants', val: '42', change: '+3', color: 'text-blue-400' },
              { label: 'WA Total Usage', val: '142k', change: '+18k', color: 'text-indigo-400' },
              { label: 'System Uptime', val: '99.99%', change: 'STABLE', color: 'text-emerald-400' },
            ].map((s, i) => (
              <div key={i} className="bg-indigo-950/50 p-6 rounded-3xl border border-indigo-900 shadow-lg">
                <p className="text-[9px] font-black text-indigo-400 uppercase tracking-widest">{s.label}</p>
                <div className="flex items-baseline gap-3 mt-2">
                   <p className="text-3xl font-black text-white">{s.val}</p>
                   <span className={`text-[10px] font-bold ${s.color}`}>{s.change}</span>
                </div>
              </div>
            ))}
          </div>

          <div className="grid grid-cols-3 gap-8">
            <div className="col-span-2 bg-indigo-950/30 rounded-[40px] border border-indigo-900 p-8">
              <div className="flex justify-between items-center mb-8">
                <h3 className="text-lg font-bold flex items-center gap-3">
                   <Globe size={20} className="text-indigo-400"/> Top Performing Tenants
                </h3>
                <button className="text-[10px] font-black text-indigo-500 hover:text-white transition-colors tracking-widest uppercase">View all 42 mosques</button>
              </div>
              <div className="space-y-4">
                 {[
                   { name: 'Al-Markaz Mosque', slug: 'al-markaz', plan: 'Premium', usage: '92%', status: 'Active' },
                   { name: 'Islamic Center Beirut', slug: 'ic-beirut', plan: 'Enterprise', usage: '45%', status: 'Active' },
                   { name: 'Saida Main Mosque', slug: 'saida-main', plan: 'Basic', usage: '102%', status: 'Quota Alert', warning: true },
                 ].map((t, i) => (
                   <div key={i} className="flex items-center justify-between p-5 rounded-2xl bg-indigo-900/20 border border-indigo-800/30 hover:border-indigo-700 transition-all">
                      <div className="flex items-center gap-4">
                         <div className="w-10 h-10 rounded-xl bg-indigo-800 flex items-center justify-center font-bold">{t.name[0]}</div>
                         <div>
                            <p className="text-sm font-bold text-white">{t.name}</p>
                            <p className="text-[10px] text-indigo-400 font-mono tracking-tight">{t.slug}.mosquesaas.com</p>
                         </div>
                      </div>
                      <div className="flex items-center gap-8">
                         <div className="text-right">
                            <p className="text-[10px] font-bold text-indigo-500 uppercase mb-1">Plan</p>
                            <p className="text-xs font-bold text-indigo-200">{t.plan}</p>
                         </div>
                         <div className="w-24 text-right">
                            <p className="text-[10px] font-bold text-indigo-500 uppercase mb-1">Usage</p>
                            <div className="w-full bg-indigo-900 h-1 rounded-full mb-1">
                               <div className={`h-full rounded-full ${t.warning ? 'bg-rose-500' : 'bg-emerald-500'}`} style={{width: t.usage}}></div>
                            </div>
                            <p className={`text-[9px] font-bold ${t.warning ? 'text-rose-400' : 'text-emerald-400'}`}>{t.usage}</p>
                         </div>
                         <div className="flex gap-2">
                            <button className="p-2 rounded-lg bg-indigo-800/50 hover:bg-indigo-700 transition-colors text-indigo-300"><Eye size={14}/></button>
                            <button className="p-2 rounded-lg bg-indigo-800/50 hover:bg-indigo-700 transition-colors text-indigo-300"><Ban size={14}/></button>
                         </div>
                      </div>
                   </div>
                 ))}
              </div>
            </div>
            
            <div className="space-y-6">
               <div className="bg-indigo-600 rounded-[40px] p-8 text-white relative overflow-hidden group shadow-2xl">
                  <div className="relative z-10">
                    <h4 className="text-lg font-bold mb-2">Plan Optimization</h4>
                    <p className="text-indigo-100 text-xs leading-relaxed mb-6">3 mosques have exceeded their Basic plan quota. Automatic upgrade recommendations ready.</p>
                    <button className="w-full bg-white text-indigo-600 font-black py-3 rounded-2xl text-[10px] tracking-widest uppercase hover:bg-indigo-50 transition-colors">REVIEW ALERTS</button>
                  </div>
                  <BarChart3 className="absolute -right-10 -bottom-10 w-40 h-40 text-white/10 group-hover:scale-110 transition-transform duration-700" />
               </div>

               <div className="bg-indigo-950/50 rounded-[40px] border border-indigo-900 p-8">
                  <h4 className="text-sm font-bold mb-6 flex items-center gap-2">
                     <AlertCircle size={16} className="text-indigo-400"/> Critical System Logs
                  </h4>
                  <div className="space-y-4">
                     {[
                       { event: 'Suspension', tenant: 'Mosque #12', actor: 'SysAdmin', time: '2m ago' },
                       { event: 'Webhook Fail', tenant: 'Wish Gateway', actor: 'System', time: '14m ago', err: true },
                       { event: 'Plan Upgrade', tenant: 'Al-Markaz', actor: 'MosqueAdmin', time: '1h ago' },
                     ].map((log, i) => (
                       <div key={i} className="flex items-center justify-between">
                          <div className="flex items-center gap-3">
                             <div className={`w-1.5 h-1.5 rounded-full ${log.err ? 'bg-rose-500 animate-pulse' : 'bg-emerald-500'}`}></div>
                             <div>
                                <p className="text-[11px] font-bold text-indigo-100">{log.event}</p>
                                <p className="text-[9px] text-indigo-500">{log.tenant} • {log.actor}</p>
                             </div>
                          </div>
                          <span className="text-[9px] text-indigo-600 font-bold">{log.time}</span>
                       </div>
                     ))}
                  </div>
               </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  );

  const renderTabContent = () => {
    switch (activeTab) {
      case DocTab.OVERVIEW:
        return (
          <div className="space-y-8 animate-in fade-in duration-500">
            <section className="bg-slate-900 text-white p-12 rounded-[40px] shadow-2xl border border-slate-700 relative overflow-hidden">
               <div className="absolute top-0 right-0 p-12 opacity-10">
                 <Server size={180} />
               </div>
               <div className="relative z-10">
                 <h2 className="text-5xl font-black mb-6 flex items-center gap-6">
                   <Terminal size={52} className="text-emerald-500" /> Enterprise SaaS Core
                 </h2>
                 <p className="text-slate-400 max-w-3xl text-2xl font-medium leading-relaxed">
                   A high-performance Laravel 11 foundation engineered for massive multi-tenancy, extreme isolation, and seamless regionalized service delivery.
                 </p>
                 <div className="mt-10 flex gap-4">
                    <div className="bg-slate-800 px-6 py-3 rounded-2xl border border-slate-700 flex items-center gap-3">
                       <CheckCircle2 className="text-emerald-500" size={18} />
                       <span className="text-sm font-bold text-slate-200">Tenant-Aware Middleware</span>
                    </div>
                    <div className="bg-slate-800 px-6 py-3 rounded-2xl border border-slate-700 flex items-center gap-3">
                       <CheckCircle2 className="text-emerald-500" size={18} />
                       <span className="text-sm font-bold text-slate-200">Global Scoping Protection</span>
                    </div>
                 </div>
               </div>
            </section>
            
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {[
                { title: 'Isolation Architecture', desc: 'Absolute logical separation using automatic global scopes and unique tenant context binding.', icon: ShieldCheck, color: 'text-emerald-500', bg: 'bg-emerald-50' },
                { title: 'Local Gateway Integration', desc: 'Securely handling Wish Money and regionalized payment providers with encrypted secret storage.', icon: CreditCard, color: 'text-blue-500', bg: 'bg-blue-50' },
                { title: 'Broadcast Engine', desc: 'Multi-threaded message queue for high-volume WhatsApp notifications through Meta Cloud API.', icon: MessageSquare, color: 'text-indigo-500', bg: 'bg-indigo-50' },
                { title: 'Quota Enforcement', desc: 'Real-time usage tracking and module access control based on subscribed platform tiers.', icon: Zap, color: 'text-amber-500', bg: 'bg-amber-50' },
                { title: 'Multi-Guard Auth', desc: 'Strict separation between platform maintainers, mosque admins, and public worshippers.', icon: Lock, color: 'text-purple-500', bg: 'bg-purple-50' },
                { title: 'Localized Prayer Logic', desc: 'Astronomical calculation service supporting all global Islamic calculation methods.', icon: Clock, color: 'text-rose-500', bg: 'bg-rose-50' }
              ].map((m, i) => (
                <div key={i} className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                  <div className={`w-14 h-14 rounded-2xl ${m.bg} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform`}>
                    <m.icon className={m.color} size={28} />
                  </div>
                  <h3 className="font-bold text-xl mb-3 text-slate-900">{m.title}</h3>
                  <p className="text-sm text-slate-500 leading-relaxed">{m.desc}</p>
                </div>
              ))}
            </div>
          </div>
        );

      case DocTab.SCHEMA:
        return (
          <div className="space-y-10 animate-in fade-in duration-500">
            <div className="flex items-center justify-between">
              <div>
                <h2 className="text-3xl font-black text-slate-900">Database Topology</h2>
                <p className="text-slate-500 mt-1">Entity-relationship definitions for multi-tenant isolation</p>
              </div>
              <div className="flex gap-2">
                 <div className="px-4 py-2 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200">ISO-8601 Standards</div>
                 <div className="px-4 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl border border-indigo-200">ACID Compliant</div>
              </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
              {SCHEMA_TABLES.map((table, i) => (
                <div key={i} className="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                  <div className="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <div>
                      <h3 className="font-bold text-slate-900 flex items-center gap-2">
                        <Database size={18} className="text-indigo-600"/> {table.name}
                      </h3>
                      <p className="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">{table.description}</p>
                    </div>
                    {table.isTenantScoped && (
                      <span className="px-3 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-full tracking-widest border border-emerald-200">TENANT SCOPED</span>
                    )}
                  </div>
                  <div className="p-6">
                    <table className="w-full text-left text-[12px]">
                      <thead>
                        <tr className="text-slate-400 font-black border-b border-slate-100">
                          <th className="pb-3 px-2">COLUMN</th>
                          <th className="pb-3 px-2">TYPE</th>
                          <th className="pb-3 px-2 text-right">ATTR</th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-slate-50">
                        {table.fields.map((field, fi) => (
                          <tr key={fi} className="hover:bg-slate-50 transition-colors">
                            <td className="py-3 px-2 font-mono text-slate-900 font-bold">
                              {field.name}
                              {field.primary && <span className="ml-1 text-amber-500" title="Primary Key">★</span>}
                            </td>
                            <td className="py-3 px-2 text-slate-500">{field.type}</td>
                            <td className="py-3 px-2 text-right">
                               <div className="flex justify-end gap-1">
                                  {field.unique && <span className="bg-blue-100 text-blue-600 px-1.5 rounded text-[8px] font-black">UNQ</span>}
                                  {field.index && <span className="bg-slate-200 text-slate-600 px-1.5 rounded text-[8px] font-black">IDX</span>}
                                  {field.nullable && <span className="bg-slate-100 text-slate-400 px-1.5 rounded text-[8px] font-black">NULL</span>}
                                  {field.foreignKey && <span className="bg-purple-100 text-purple-600 px-1.5 rounded text-[8px] font-black">FK</span>}
                               </div>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              ))}
            </div>

            <div className="bg-slate-900 p-10 rounded-[40px] text-white">
              <h4 className="text-lg font-bold mb-6 flex items-center gap-3"><ArrowRight size={20} className="text-emerald-500"/> Performance Indexes</h4>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {IMPORTANT_INDEXES.map((idx, i) => (
                  <div key={i} className="bg-slate-800 p-6 rounded-3xl border border-slate-700">
                     <p className="font-mono text-emerald-400 text-sm mb-2">{idx.columns.join(' + ')}</p>
                     <p className="text-xs text-slate-400 leading-relaxed">{idx.reason}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        );

      case DocTab.ROUTING_AUTH:
        return (
          <div className="space-y-8 animate-in slide-in-from-right duration-300">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-10">
               <div className="space-y-6">
                 <h3 className="text-2xl font-black text-slate-900">Isolation Layer</h3>
                 <p className="text-slate-500 text-sm leading-relaxed">
                   Every request passes through the <code className="bg-slate-200 px-1 rounded font-bold text-slate-900">IdentifyTenant</code> middleware.
                   If resolved via custom domain or slug, the tenant singleton is bound, and the database global scope ensures no "cross-talk" between mosque data.
                 </p>
                 <CodeBlock title="app/Models/BaseTenantModel.php" code={MODULE_CODE.TENANT_ISOLATION} icon={ShieldCheck} />
                 <CodeBlock title="Platform Admin Routing" code={MODULE_CODE.PLATFORM_ROUTING} icon={Lock} />
                 <div className="p-6 bg-indigo-50 border border-indigo-100 rounded-3xl">
                    <h4 className="font-bold text-indigo-900 mb-2 flex items-center gap-2"><Lock size={16}/> Multi-Guard Implementation</h4>
                    <ul className="text-xs text-indigo-800 space-y-3">
                      <li className="flex gap-3">
                        <span className="font-black text-indigo-900 shrink-0">web</span>
                        <span>Standard user session (Public users)</span>
                      </li>
                      <li className="flex gap-3">
                        <span className="font-black text-indigo-900 shrink-0">tenant</span>
                        <span>Mosque admin session (Imams, Editors)</span>
                      </li>
                      <li className="flex gap-3">
                        <span className="font-black text-indigo-900 shrink-0">platform</span>
                        <span>Super-admin control session (Maintenance)</span>
                      </li>
                    </ul>
                 </div>
               </div>
               <div className="space-y-6">
                  <h3 className="text-2xl font-black text-slate-900">Endpoint Mapping</h3>
                  <CodeBlock title="routes/web.php (Logic)" code={MODULE_CODE.ROUTING_BLUEPRINT} icon={RouteIcon} />
                  <CodeBlock title="Reseller Scoping Logic" code={MODULE_CODE.RESELLER_SCOPING} icon={Users} />
                  <div className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                     <h4 className="font-bold text-slate-800 mb-4">Middleware Stack</h4>
                     <div className="space-y-3">
                        {[
                          { name: 'tenant.resolve', desc: 'Finds mosque by Host or URL Segment' },
                          { name: 'tenant.limit', desc: 'Enforces plan usage (e.g. storage/msg quota)' },
                          { name: 'module:{name}', desc: 'Checks if module is enabled in plan' },
                          { name: 'auth:tenant', desc: 'Mosque-specific administrative access' }
                        ].map((mw, i) => (
                          <div key={i} className="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
                            <CheckCircle2 size={16} className="text-emerald-500 shrink-0 mt-0.5" />
                            <div>
                               <p className="text-xs font-black text-slate-900">{mw.name}</p>
                               <p className="text-[10px] text-slate-500">{mw.desc}</p>
                            </div>
                          </div>
                        ))}
                     </div>
                  </div>
               </div>
            </div>
          </div>
        );

      case DocTab.SITE_PREVIEWS:
        return (
          <div className="space-y-10 animate-in fade-in duration-500">
            <div className="flex items-center justify-between">
              <div>
                <h2 className="text-3xl font-black text-slate-900 flex items-center gap-3">
                   <Monitor size={32} className="text-indigo-600" /> UX Simulator
                </h2>
                <p className="text-slate-500 text-sm mt-1">Live architectural demonstration of the platform layers</p>
              </div>
              <div className="flex bg-white rounded-2xl border border-slate-200 p-1.5 shadow-sm">
                <button 
                  onClick={() => setActivePreview('public')}
                  className={`px-6 py-2.5 text-xs font-black rounded-xl transition-all tracking-wider ${activePreview === 'public' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50'}`}
                >
                  PUBLIC SITE
                </button>
                <button 
                  onClick={() => setActivePreview('tenant')}
                  className={`px-6 py-2.5 text-xs font-black rounded-xl transition-all tracking-wider ${activePreview === 'tenant' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50'}`}
                >
                  TENANT ADMIN
                </button>
                <button 
                  onClick={() => setActivePreview('platform')}
                  className={`px-6 py-2.5 text-xs font-black rounded-xl transition-all tracking-wider ${activePreview === 'platform' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50'}`}
                >
                  PLATFORM CORE
                </button>
              </div>
            </div>

            <div className="relative group">
              <div className="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-[30px] blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
              <div className="relative">
                {activePreview === 'public' && <SimulatedPublicSite />}
                {activePreview === 'tenant' && <SimulatedTenantAdmin />}
                {activePreview === 'platform' && <SimulatedPlatformAdmin />}
              </div>
            </div>
          </div>
        );

      case DocTab.DEPLOYMENT:
        return (
          <div className="animate-in slide-in-from-right duration-300 space-y-10">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-10">
              <div className="space-y-6">
                <h3 className="text-2xl font-black text-slate-900">Stack Configuration</h3>
                <CodeBlock title="docker-compose.yml" code={MODULE_CODE.DOCKER_STACK} icon={Box} />
                <div className="bg-amber-50 border border-amber-200 p-8 rounded-3xl">
                   <h4 className="font-bold text-amber-900 mb-2 flex items-center gap-2"><Info size={16}/> High Availability</h4>
                   <p className="text-xs text-amber-800 leading-relaxed">
                     Worker nodes are scaled independently of the web application. Scheduled jobs (Friday Reminders) are processed by dedicated cron containers to ensure reliability.
                   </p>
                </div>
              </div>
              <div className="space-y-6">
                <h3 className="text-2xl font-black text-slate-900">Server Topology</h3>
                <CodeBlock title="nginx.conf (Wildcard Hosting)" code={MODULE_CODE.NGINX_SAAS} icon={Globe} />
                <CodeBlock title="supervisor-worker.conf" code={MODULE_CODE.SUPERVISOR_CONF} icon={Activity} />
              </div>
            </div>
          </div>
        );

      case DocTab.MODULE_WHATSAPP:
        return (
          <div className="animate-in fade-in duration-300 space-y-8">
             <div className="flex justify-between items-end">
                <div>
                   <h2 className="text-3xl font-black text-slate-900">WhatsApp Broadcast Engine</h2>
                   <p className="text-slate-500">Massive scale notification delivery pipeline</p>
                </div>
                <div className="bg-indigo-600 text-white px-6 py-2 rounded-xl text-xs font-bold shadow-lg">Meta Cloud API V18.0</div>
             </div>
             <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <CodeBlock title="app/Jobs/EnqueueBroadcastJob.php" code={MODULE_CODE.WHATSAPP_BROADCAST} icon={MessageSquare} />
                <div className="space-y-6">
                   <div className="bg-white p-8 rounded-[40px] border border-slate-200 shadow-sm">
                      <h4 className="font-black text-slate-900 mb-4 flex items-center gap-3">
                         <Activity size={20} className="text-emerald-500"/> Broadcast Lifecycle
                      </h4>
                      <div className="space-y-6 relative ml-2">
                         <div className="absolute left-[-2px] top-2 bottom-2 w-0.5 bg-slate-100"></div>
                         {[
                           { t: 'Batching', desc: 'Break segment (e.g. 5,000 users) into manageable chunks.' },
                           { t: 'Template Hydration', desc: 'Replace variables with localized subscriber data.' },
                           { t: 'Quota Validation', desc: 'Verify mosque has remaining monthly message tokens.' },
                           { t: 'Provider Dispatch', desc: 'Push to Meta Cloud API via SendWhatsAppMessageJob.' }
                         ].map((step, i) => (
                           <div key={i} className="relative pl-6">
                              <div className="absolute left-[-6px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-primary"></div>
                              <p className="text-sm font-bold text-slate-900">{step.t}</p>
                              <p className="text-xs text-slate-500">{step.desc}</p>
                           </div>
                         ))}
                      </div>
                   </div>
                   <div className="bg-slate-900 p-8 rounded-[40px] text-white">
                      <p className="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Consent Compliance</p>
                      <p className="text-xs text-slate-400 leading-relaxed">
                        Automatic unsubscription logic via "STOP" keyword detection and mandatory opt-in logging (ip_hash + timestamp) maintained for carrier audit trails.
                      </p>
                   </div>
                </div>
             </div>
          </div>
        );

      case DocTab.MODULE_PAYMENTS:
        return (
          <div className="animate-in slide-in-from-right duration-300 space-y-10">
            <div className="flex justify-between items-center">
               <div>
                  <h2 className="text-3xl font-black text-slate-900">Wish Money Gateway</h2>
                  <p className="text-slate-500">Regional payment processing integration</p>
               </div>
               <div className="flex gap-2">
                  <span className="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg">ENCRYPTED CREDENTIALS</span>
                  <span className="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black rounded-lg">SIGNED WEBHOOKS</span>
               </div>
            </div>
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <CodeBlock title="app/Services/Payments/WishMoneyGateway.php" code={MODULE_CODE.WISH_MONEY_GATEWAY} icon={CreditCard} />
              <div className="space-y-8">
                <div className="bg-indigo-900 p-10 rounded-[50px] text-white shadow-2xl">
                   <h4 className="text-xl font-bold mb-6 flex items-center gap-3"><ArrowRight size={24} className="text-emerald-400"/> Transaction Logic</h4>
                   <p className="text-indigo-200 text-sm leading-relaxed mb-8">
                     Tenant credentials are encrypted using Laravel's AES-256-CBC. Inbound webhooks require a 256-bit HMAC signature verification using a per-tenant shared secret to prevent spoofing.
                   </p>
                   <div className="space-y-4">
                      <div className="flex items-center gap-3">
                         <div className="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[10px] font-bold">1</div>
                         <span className="text-xs font-medium">Initialize signed Checkout URL</span>
                      </div>
                      <div className="flex items-center gap-3">
                         <div className="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[10px] font-bold">2</div>
                         <span className="text-xs font-medium">Verify "paid" status via signed Webhook</span>
                      </div>
                      <div className="flex items-center gap-3">
                         <div className="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[10px] font-bold">3</div>
                         <span className="text-xs font-medium">Record DonationTransaction & Dispatch Receipt Job</span>
                      </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
        );

      case DocTab.MODULE_PRAYER:
        return (
          <div className="animate-in fade-in duration-300 space-y-8">
             <div className="flex justify-between items-center">
                <h2 className="text-3xl font-black text-slate-900">Astronomical Service</h2>
                <div className="flex gap-2">
                   <div className="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-lg">ISNA / MWL / EGYPT</div>
                   <div className="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg">MANUAL OFFSETS</div>
                </div>
             </div>
             <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div className="bg-white p-10 rounded-[40px] border border-slate-200 shadow-sm space-y-6">
                   <h4 className="font-black text-slate-900 flex items-center gap-3"><Clock size={24} className="text-amber-500"/> Calculation Core</h4>
                   <p className="text-slate-500 text-sm leading-relaxed">
                     The service calculates prayer times based on Latitude, Longitude, and preferred calculation method stored in tenant settings.
                     Adjustments (minutes +/-) can be applied per-prayer for regional custom adherence.
                   </p>
                   <div className="pt-4 grid grid-cols-2 gap-4">
                      <div className="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                         <p className="text-[10px] font-black uppercase text-slate-400 mb-1">Method</p>
                         <p className="text-sm font-bold text-slate-800">Islamic Soc. of NA</p>
                      </div>
                      <div className="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                         <p className="text-[10px] font-black uppercase text-slate-400 mb-1">Offset</p>
                         <p className="text-sm font-bold text-slate-800">Asr +5m (Manual)</p>
                      </div>
                   </div>
                </div>
                <CodeBlock title="app/Services/PrayerTimesService.php" code={MODULE_CODE.PRAYER_SERVICE} icon={Zap} />
             </div>
          </div>
        );

      case DocTab.MODULE_ENTERPRISE:
        return (
           <div className="space-y-10 animate-in fade-in duration-500">
              <div className="flex items-center justify-between">
                 <div>
                    <h2 className="text-3xl font-black text-slate-900">Platform Management (Step 6)</h2>
                    <p className="text-slate-500">Super-admin controls for mosque lifecycle and usage monitoring</p>
                 </div>
                 <div className="px-4 py-2 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl border border-indigo-200">SAAS CORE</div>
              </div>

              <div className="grid grid-cols-1 lg:grid-cols-2 gap-10">
                 <div className="space-y-6">
                    <h3 className="text-xl font-bold flex items-center gap-2 text-slate-800"><Activity size={20} className="text-indigo-600"/> Quota Enforcement</h3>
                    <p className="text-sm text-slate-500 leading-relaxed">
                       Dynamic logic that aggregates usage across multiple dimensions (e.g. monthly WhatsApp tokens) while respecting plan overrides set by Super Admins.
                    </p>
                    <CodeBlock title="app/Models/Mosque.php (Usage Method)" code={MODULE_CODE.USAGE_ENFORCEMENT} icon={Zap} />
                 </div>
                 <div className="space-y-6">
                    <h3 className="text-xl font-bold flex items-center gap-2 text-slate-800"><ShieldCheck size={20} className="text-emerald-600"/> Feature Overrides</h3>
                    <p className="text-sm text-slate-500 leading-relaxed">
                       Allows the platform owner to manually enable high-tier features for specific mosques (e.g. for beta testing or custom sales) without changing their formal plan.
                    </p>
                    <div className="p-8 bg-white border border-slate-200 rounded-[40px] shadow-sm">
                       <h4 className="font-bold text-slate-900 mb-4">Override Schema</h4>
                       <table className="w-full text-[11px]">
                          <thead>
                             <tr className="text-slate-400 uppercase font-black tracking-widest border-b border-slate-100">
                                <th className="pb-2 text-left">COL</th>
                                <th className="pb-2 text-left">TYPE</th>
                                <th className="pb-2 text-right">DESC</th>
                             </tr>
                          </thead>
                          <tbody className="divide-y divide-slate-50">
                             <tr><td className="py-2 font-mono">feature_name</td><td className="py-2">string</td><td className="py-2 text-right">e.g. 'whatsapp'</td></tr>
                             <tr><td className="py-2 font-mono">enabled</td><td className="py-2">boolean</td><td className="py-2 text-right">Hard override</td></tr>
                             <tr><td className="py-2 font-mono">custom_limits</td><td className="py-2">json</td><td className="py-2 text-right">Limit overrides</td></tr>
                          </tbody>
                       </table>
                    </div>
                 </div>
              </div>
           </div>
        );

      default:
        return (
          <div className="flex flex-col items-center justify-center p-20 text-center space-y-4">
             <div className="bg-slate-100 p-8 rounded-full">
                <Box size={64} className="text-slate-300" />
             </div>
             <h3 className="text-xl font-bold text-slate-800 tracking-tight">Technical details in development</h3>
             <p className="text-slate-400 max-w-sm">This architectural module is currently being hydrated with implementation details from the blueprint.</p>
          </div>
        );
    }
  };

  return (
    <div className="min-h-screen pb-20 bg-slate-50 text-slate-900 selection:bg-indigo-100 selection:text-indigo-900">
      <header className="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-20">
            <div className="flex items-center gap-4">
              <div className="bg-slate-950 p-3 rounded-[1.25rem] shadow-2xl">
                <Terminal className="text-emerald-500" size={28} />
              </div>
              <div>
                <h1 className="text-2xl font-black tracking-tight text-slate-900">MosqueSaaS <span className="text-emerald-600">Architect</span></h1>
                <p className="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Platform Blueprint v6.0</p>
              </div>
            </div>
            <div className="flex items-center gap-6">
              <div className="hidden md:flex gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 rounded-2xl items-center">
                 <div className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                 <span className="text-[10px] font-black uppercase tracking-widest text-slate-500">Live Blueprint</span>
              </div>
              <span className="px-5 py-2 bg-slate-950 text-emerald-400 text-xs font-black rounded-2xl border border-slate-800 shadow-xl tracking-widest">PHASE 6: PLATFORM ADMIN</span>
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div className="flex flex-col lg:flex-row gap-12">
          <nav className="w-full lg:w-80 space-y-1.5 shrink-0 sticky top-32 h-fit">
            <div className="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Core Documentation</div>
            
            {[
              { id: DocTab.OVERVIEW, icon: LayoutDashboard, label: 'Architectural Overview' },
              { id: DocTab.SITE_PREVIEWS, icon: Monitor, label: 'UI / UX Simulator' },
              { id: DocTab.ROUTING_AUTH, icon: RouteIcon, label: 'Routing & Auth Logic' },
              { id: DocTab.SCHEMA, icon: Database, label: 'Schema & Topology' },
              { id: DocTab.DEPLOYMENT, icon: Server, label: 'DevOps & CI / CD' },
            ].map((item) => (
              <button 
                key={item.id}
                onClick={() => setActiveTab(item.id)} 
                className={`w-full flex items-center justify-between gap-3 px-5 py-3.5 text-sm font-bold rounded-2xl transition-all group ${activeTab === item.id ? 'bg-slate-950 text-white shadow-2xl translate-x-1' : 'text-slate-600 hover:bg-slate-100'}`}
              >
                <div className="flex items-center gap-3">
                  <item.icon size={18} className={activeTab === item.id ? 'text-emerald-500' : 'text-slate-400'} /> 
                  {item.label}
                </div>
                <ChevronRight size={14} className={`opacity-0 group-hover:opacity-40 transition-opacity ${activeTab === item.id ? 'hidden' : 'block'}`} />
              </button>
            ))}
            
            <div className="px-4 py-2 mt-10 text-[10px] font-black text-emerald-600 uppercase tracking-widest border-t border-slate-200 pt-8 mb-2">Module Blueprints</div>
            
            {[
              { id: DocTab.MODULE_ENTERPRISE, icon: LifeBuoy, label: 'Platform Management' },
              { id: DocTab.MODULE_WHATSAPP, icon: MessageSquare, label: 'WhatsApp Broadcast' },
              { id: DocTab.MODULE_PAYMENTS, icon: CreditCard, label: 'WishMoney Checkout' },
              { id: DocTab.MODULE_PRAYER, icon: Clock, label: 'Prayer Calculation' },
            ].map((item) => (
              <button 
                key={item.id}
                onClick={() => setActiveTab(item.id)} 
                className={`w-full flex items-center gap-3 px-5 py-3.5 text-sm font-bold rounded-2xl transition-all group ${activeTab === item.id ? 'bg-emerald-600 text-white shadow-xl translate-x-1' : 'text-slate-600 hover:bg-emerald-50'}`}
              >
                <item.icon size={18} className={activeTab === item.id ? 'text-white' : 'text-emerald-500'} /> 
                {item.label}
              </button>
            ))}

            <div className="mt-12 p-8 bg-slate-950 rounded-[2.5rem] text-white shadow-2xl border border-slate-800 relative overflow-hidden group">
                <Zap size={100} className="absolute -right-12 -bottom-12 text-emerald-500/10 group-hover:scale-110 transition-transform duration-700" />
                <div className="relative z-10">
                   <h5 className="text-[10px] uppercase font-black text-slate-500 mb-4 tracking-[0.2em] flex items-center gap-2">
                     <Activity size={14} className="text-emerald-500"/> System Health
                   </h5>
                   <div className="space-y-4">
                       <div className="flex justify-between items-center text-xs">
                           <span className="text-slate-400">Tenant Isolation</span>
                           <span className="text-emerald-400 font-black">STRICT</span>
                       </div>
                       <div className="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                           <div className="h-full bg-emerald-500 w-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                       </div>
                       <div className="pt-2 flex justify-between items-center text-xs">
                           <span className="text-slate-400">Response Guard</span>
                           <span className="text-blue-400 font-black">99.9%</span>
                       </div>
                       <div className="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                           <div className="h-full bg-blue-500 w-[99.9%] shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                       </div>
                   </div>
                </div>
            </div>
          </nav>

          <div className="flex-1 min-w-0">
            {renderTabContent()}
          </div>
        </div>
      </main>

      <div className="fixed bottom-8 left-1/2 -translate-x-1/2 z-[60] group pointer-events-none sm:pointer-events-auto">
        <div className="bg-slate-950/90 backdrop-blur-xl text-white px-10 py-6 rounded-full shadow-[0_35px_60px_-15px_rgba(0,0,0,0.5)] flex items-center gap-12 border border-slate-800 ring-1 ring-white/10 transition-all hover:scale-105">
           <div className="flex items-center gap-4">
             <div className="relative">
               <div className="w-3 h-3 rounded-full bg-emerald-500 animate-ping absolute inset-0"></div>
               <div className="w-3 h-3 rounded-full bg-emerald-500 relative"></div>
             </div>
             <div className="flex flex-col">
               <span className="text-[10px] text-slate-500 uppercase font-black tracking-widest">Active Phase</span>
               <span className="text-sm font-black text-emerald-400 tracking-wider">PLATFORM CORE</span>
             </div>
           </div>
           <div className="h-8 w-[1px] bg-slate-800"></div>
           <div className="flex gap-10">
              <div className="flex flex-col">
                <span className="text-[10px] text-slate-500 uppercase font-black tracking-widest">Backend</span>
                <span className="text-xs text-white font-black">LARAVEL 11</span>
              </div>
              <div className="flex flex-col">
                <span className="text-[10px] text-slate-500 uppercase font-black tracking-widest">Isolation</span>
                <span className="text-xs text-blue-400 font-black">SINGLE DB / SCOPED</span>
              </div>
           </div>
        </div>
      </div>
    </div>
  );
};

export default App;
