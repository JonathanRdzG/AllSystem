export const sameId = (left, right) => String(left ?? '') === String(right ?? '');

export const filterByCompany = (items = [], companyId) => {
  if (!companyId) {
    return items;
  }

  return items.filter((item) => sameId(item.company_id, companyId));
};

export const quoteOptionLabel = (quote) => {
  const customer = quote.customer?.name ?? 'Sin cliente';
  const total = Number(quote.total ?? 0).toLocaleString('es-MX', {
    style: 'currency',
    currency: 'MXN',
  });

  return `#${quote.id} · ${customer} · ${quote.status} · ${total}`;
};
