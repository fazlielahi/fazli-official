(function () {
    const toolbar = document.getElementById('blogs-toolbar');
    const resultsRoot = document.getElementById('blogs-results');
    if (!toolbar || !resultsRoot) {
        return;
    }

    const searchInput = document.getElementById('blogs-search-input');
    const sortSelect = document.getElementById('blogs-sort-select');
    const dropdown = document.getElementById('blogs-search-dropdown');
    const metaEl = document.getElementById('blogs-toolbar-meta');

    const listUrl = toolbar.dataset.listUrl;
    const searchUrl = toolbar.dataset.searchUrl;
    const categoryId = toolbar.dataset.categoryId || '';
    const seeAllTemplate = toolbar.dataset.seeAllLabel || 'See all results (:total)';
    const noResultsLabel = toolbar.dataset.noResultsLabel || 'No matching blogs';
    const searchingLabel = toolbar.dataset.searchingLabel || 'Searching...';

    let previewTimer = null;
    let previewRequest = null;
    let resultsRequest = null;
    let lastPreviewQuery = '';
    let activeSearchQuery = searchInput ? searchInput.value.trim() : '';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function buildParams(overrides) {
        const params = new URLSearchParams();
        const q = (overrides && overrides.q !== undefined) ? overrides.q : (searchInput ? searchInput.value.trim() : '');
        const sort = (overrides && overrides.sort !== undefined) ? overrides.sort : (sortSelect ? sortSelect.value : 'newest');
        const page = (overrides && overrides.page) ? overrides.page : '1';

        if (q) {
            params.set('q', q);
        }
        if (sort && sort !== 'newest') {
            params.set('sort', sort);
        }
        if (page && page !== '1') {
            params.set('page', page);
        }

        return params;
    }

    function updateUrl(params) {
        const query = params.toString();
        const nextUrl = query ? `${listUrl}?${query}` : listUrl;
        window.history.replaceState({}, '', nextUrl);
    }

    function setResultsLoading(isLoading) {
        resultsRoot.classList.toggle('is-loading', isLoading);
    }

    function setMeta(text) {
        if (!metaEl) {
            return;
        }
        metaEl.textContent = text || '';
        metaEl.style.display = text ? '' : 'none';
    }

    function hideDropdown() {
        if (!dropdown) {
            return;
        }
        dropdown.hidden = true;
        dropdown.innerHTML = '';
        if (searchInput) {
            searchInput.setAttribute('aria-expanded', 'false');
        }
    }

    function showDropdown() {
        if (!dropdown) {
            return;
        }
        dropdown.hidden = false;
        if (searchInput) {
            searchInput.setAttribute('aria-expanded', 'true');
        }
    }

    function formatSeeAllLabel(total) {
        return seeAllTemplate.replace(':total', String(total));
    }

    function renderPreviewDropdown(data, query) {
        if (!dropdown) {
            return;
        }

        if (!query || query.length < 2) {
            hideDropdown();
            return;
        }

        showDropdown();

        if (!data.items || data.items.length === 0) {
            dropdown.innerHTML = `<div class="blogs-search-dropdown__empty">${escapeHtml(noResultsLabel)}</div>`;
            return;
        }

        const itemsHtml = data.items.map(function (item) {
            return `
                <a href="${escapeHtml(item.url)}" class="blogs-search-dropdown__item" role="option">
                    <img src="${escapeHtml(item.thumb)}" alt="" class="blogs-search-dropdown__thumb" loading="lazy">
                    <span class="blogs-search-dropdown__title">${escapeHtml(item.title)}</span>
                </a>
            `;
        }).join('');

        const seeAllHtml = data.total > 0
            ? `<button type="button" class="blogs-search-dropdown__see-all" data-query="${escapeHtml(query)}">${escapeHtml(formatSeeAllLabel(data.total))}</button>`
            : '';

        dropdown.innerHTML = itemsHtml + seeAllHtml;
    }

    function fetchPreview(query) {
        if (!searchUrl || query.length < 2) {
            hideDropdown();
            return;
        }

        if (previewRequest) {
            previewRequest.abort();
        }

        lastPreviewQuery = query;
        showDropdown();
        dropdown.innerHTML = `<div class="blogs-search-dropdown__loading">${escapeHtml(searchingLabel)}</div>`;

        const params = new URLSearchParams({ q: query });
        if (categoryId) {
            params.set('category_id', categoryId);
        }

        previewRequest = new AbortController();

        fetch(`${searchUrl}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            signal: previewRequest.signal,
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (searchInput && searchInput.value.trim() !== lastPreviewQuery) {
                    return;
                }
                renderPreviewDropdown(data, query);
            })
            .catch(function (err) {
                if (err.name !== 'AbortError') {
                    console.error('Blog search preview error:', err);
                }
            });
    }

    function dismissOpenModals() {
        document.querySelectorAll('.modal.show').forEach(function (modalEl) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const instance = bootstrap.Modal.getInstance(modalEl);
                if (instance) {
                    instance.hide();
                }
            }
            modalEl.classList.remove('show');
            modalEl.setAttribute('aria-hidden', 'true');
            modalEl.style.display = 'none';
        });

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
        document.querySelectorAll('.modal-backdrop').forEach(function (el) {
            el.remove();
        });
    }

    function loadResults(overrides) {
        if (resultsRequest) {
            resultsRequest.abort();
        }

        const params = buildParams(overrides);
        updateUrl(params);

        setResultsLoading(true);
        hideDropdown();

        resultsRequest = new AbortController();

        fetch(`${listUrl}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            signal: resultsRequest.signal,
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                dismissOpenModals();
                resultsRoot.innerHTML = data.html || '';
                setMeta(data.meta || '');
                setResultsLoading(false);
                activeSearchQuery = (overrides && overrides.q !== undefined)
                    ? overrides.q
                    : (searchInput ? searchInput.value.trim() : '');
                if (typeof WOW !== 'undefined') {
                    new WOW({ live: true }).init();
                }
            })
            .catch(function (err) {
                if (err.name !== 'AbortError') {
                    console.error('Blog filter error:', err);
                    setResultsLoading(false);
                }
            });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();
            clearTimeout(previewTimer);

            if (query.length < 2) {
                hideDropdown();
                if (activeSearchQuery.length >= 2) {
                    activeSearchQuery = '';
                    loadResults({ q: '', page: '1' });
                }
                return;
            }

            previewTimer = setTimeout(function () {
                fetchPreview(query);
            }, 280);
        });

        searchInput.addEventListener('focus', function () {
            const query = searchInput.value.trim();
            if (query.length >= 2) {
                fetchPreview(query);
            }
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                hideDropdown();
            }
            if (e.key === 'Enter') {
                e.preventDefault();
                loadResults({ page: '1' });
            }
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            loadResults({ page: '1' });
        });
    }

    if (dropdown) {
        dropdown.addEventListener('click', function (e) {
            const seeAllBtn = e.target.closest('.blogs-search-dropdown__see-all');
            if (seeAllBtn) {
                e.preventDefault();
                const query = seeAllBtn.dataset.query || (searchInput ? searchInput.value.trim() : '');
                if (searchInput) {
                    searchInput.value = query;
                }
                loadResults({ q: query, page: '1' });
            }
        });
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.blogs-toolbar__search')) {
            hideDropdown();
        }
    });

    resultsRoot.addEventListener('click', function (e) {
        const pageLink = e.target.closest('.blogs-pagination a.page-link');
        if (!pageLink || !pageLink.href) {
            return;
        }

        e.preventDefault();
        const url = new URL(pageLink.href);
        const page = url.searchParams.get('page') || '1';
        const q = url.searchParams.get('q') || '';
        const sort = url.searchParams.get('sort') || 'newest';

        if (searchInput && q) {
            searchInput.value = q;
        }
        if (sortSelect && sort) {
            sortSelect.value = sort;
        }

        loadResults({ q: q, sort: sort, page: page });
    });
})();
