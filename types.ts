
export interface SchemaField {
  name: string;
  type: string;
  nullable?: boolean;
  unsigned?: boolean;
  unique?: boolean;
  index?: boolean;
  /* Fixed: added primary property to resolve SchemaField literal errors */
  primary?: boolean;
  foreignKey?: {
    table: string;
    on: string;
    onDelete?: 'cascade' | 'set null' | 'restrict';
  };
  comment?: string;
  default?: string;
}

export interface SchemaTable {
  name: string;
  description: string;
  fields: SchemaField[];
  isTenantScoped: boolean;
}

export interface IndexExplanation {
  columns: string[];
  reason: string;
}

export enum DocTab {
  OVERVIEW = 'overview',
  SCHEMA = 'schema',
  ROUTING_AUTH = 'routing_auth',
  MODULE_PRAYER = 'module_prayer',
  MODULE_CONTENT = 'module_content',
  MODULE_DONATIONS = 'module_donations',
  MODULE_PAYMENTS = 'module_payments',
  MODULE_WHATSAPP = 'module_whatsapp',
  MODULE_ENTERPRISE = 'module_enterprise',
  DEPLOYMENT = 'deployment',
  SERVICES = 'services',
  UI_VIEWS = 'ui_views',
  SITE_PREVIEWS = 'site_previews'
}