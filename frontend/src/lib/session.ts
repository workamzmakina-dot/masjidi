export const sessionKeys = {
  tenantSlug: 'tenant_slug',
  tenantEmail: 'tenant_email',
  platformEmail: 'platform_email',
};

export function setTenantSession(slug: string, email: string) {
  localStorage.setItem(sessionKeys.tenantSlug, slug);
  localStorage.setItem(sessionKeys.tenantEmail, email);
}

export function getTenantSession() {
  return {
    slug: localStorage.getItem(sessionKeys.tenantSlug) ?? '',
    email: localStorage.getItem(sessionKeys.tenantEmail) ?? '',
  };
}

export function setPlatformSession(email: string) {
  localStorage.setItem(sessionKeys.platformEmail, email);
}

export function getPlatformSession() {
  return {
    email: localStorage.getItem(sessionKeys.platformEmail) ?? '',
  };
}
