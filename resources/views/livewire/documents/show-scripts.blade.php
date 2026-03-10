@push('scripts')
    <script>
        function documentViewer() {
            let pdfDoc = null;
            let pdfViewer = null;
            let pdfLinkService = null;
            let pdfFindController = null;
            let eventBus = null;
            let loadingTask = null;
            let saveTimer = null;
            let resizeObserver = null;  // tracks container size changes

            return {
                showPreview: false,
                loading: true,
                error: false,
                errorMessage: '',

                page: 1,
                numPages: 0,
                pageInput: 1,
                scale: 1.0,

                searchQuery: '',
                matchesCount: {
                    current: 0,
                    total: 0
                },

                showMobileSearch: false,

                _startPage: 1,
                _isInReadLater: false,

                init() {
                    // workerSrc already set globally in pdf-viewer.js via Vite

                    this.$watch('$wire.isInReadLater', (val) => {
                        this._isInReadLater = val;
                    });
                },

                openPreview(url, startPage = 1, isInReadLater = false) {
                    this._startPage = startPage;
                    this._isInReadLater = isInReadLater;

                    this.showPreview = true;
                    this.loading = true;
                    this.error = false;
                    this.searchQuery = '';
                    this.matchesCount = { current: 0, total: 0 };

                    // Wait for the modal to be visible and have dimensions
                    // before initializing — avoids zero-size container issues
                    this.$nextTick(() => {
                        setTimeout(() => this.initializeViewer(url), 100);
                    });
                },

                closePreview() {
                    this.showPreview = false;
                    this.showMobileSearch = false;
                    this.searchQuery = '';
                    clearTimeout(saveTimer);

                    if (resizeObserver) {
                        resizeObserver.disconnect();
                        resizeObserver = null;
                    }

                    if (loadingTask) {
                        loadingTask.destroy();
                        loadingTask = null;
                    }

                    pdfViewer = null;
                    pdfLinkService = null;
                    pdfFindController = null;
                    eventBus = null;
                    pdfDoc = null;

                    const container = document.getElementById('viewerContainer');
                    if (container) {
                        container.innerHTML = '<div id="viewer" class="pdfViewer"></div>';
                        container.scrollTop = 0;
                    }
                },

                async initializeViewer(url) {
                    const container = document.getElementById('viewerContainer');
                    if (!container) return;

                    if (!pdfViewer) {
                        eventBus = new pdfjsViewer.EventBus();

                        pdfLinkService = new pdfjsViewer.PDFLinkService({
                            eventBus: eventBus,
                        });

                        pdfFindController = new pdfjsViewer.PDFFindController({
                            eventBus: eventBus,
                            linkService: pdfLinkService,
                        });

                        pdfViewer = new pdfjsViewer.PDFViewer({
                            container: container,
                            eventBus: eventBus,
                            linkService: pdfLinkService,
                            findController: pdfFindController,
                            renderer: 'canvas',
                            textLayerMode: 1,
                            maxCanvasPixels: 16777216,
                        });

                        pdfLinkService.setViewer(pdfViewer);

                        // Re-apply scale whenever the container is resized —
                        // this covers DevTools opening, window resize, orientation change
                        resizeObserver = new ResizeObserver(() => {
                            if (pdfViewer && !this.loading) {
                                // Reassigning currentScaleValue forces PDF.js
                                // to recalculate page dimensions and re-render
                                pdfViewer.currentScaleValue = pdfViewer.currentScaleValue;
                            }
                        });
                        resizeObserver.observe(container);

                        eventBus.on('pagesinit', () => {
                            pdfViewer.currentScaleValue = window.innerWidth < 768
                                ? 'page-width'
                                : 'auto';

                            if (this._startPage > 1) {
                                // Defer the page jump one tick so the viewer
                                // has finished laying out all page placeholders
                                // before we scroll — prevents blank page on resume
                                setTimeout(() => {
                                    pdfViewer.currentPageNumber = this._startPage;
                                    pdfViewer.update();
                                }, 50);
                            }

                            this.loading = false;
                        });

                        eventBus.on('pagechanging', (evt) => {
                            this.page = evt.pageNumber;
                            this.pageInput = evt.pageNumber;

                            if (this._isInReadLater) {
                                clearTimeout(saveTimer);
                                saveTimer = setTimeout(() => {
                                    window.dispatchEvent(new CustomEvent('pdf-progress', {
                                        detail: { page: evt.pageNumber }
                                    }));
                                }, 1500);
                            }
                        });

                        eventBus.on('scalechanging', (evt) => {
                            this.scale = evt.scale;
                        });

                        eventBus.on('updatefindcontrolstate', (data) => {
                            if (data.matchesCount) {
                                this.matchesCount = {
                                    current: data.matchesCount.current || 0,
                                    total: data.matchesCount.total || 0
                                };
                            }
                        });
                    }

                    try {
                        loadingTask = pdfjsLib.getDocument(url);
                        pdfDoc = await loadingTask.promise;

                        pdfViewer.setDocument(pdfDoc);
                        pdfLinkService.setDocument(pdfDoc);

                        this.numPages = pdfDoc.numPages;

                    } catch (err) {
                        console.error('Error loading PDF:', err);
                        this.error = true;
                        this.errorMessage = 'Could not load the document.';
                        this.loading = false;
                    }
                },

                jumpToPage() {
                    if (!pdfViewer) return;
                    let p = parseInt(this.pageInput);
                    if (p >= 1 && p <= this.numPages) {
                        pdfViewer.currentPageNumber = p;
                    } else {
                        this.pageInput = this.page;
                    }
                },

                nextPage() {
                    if (pdfViewer && this.page < this.numPages) pdfViewer.currentPageNumber++;
                },

                prevPage() {
                    if (pdfViewer && this.page > 1) pdfViewer.currentPageNumber--;
                },

                zoomIn() {
                    if (pdfViewer) pdfViewer.currentScale += 0.2;
                },

                zoomOut() {
                    if (pdfViewer && pdfViewer.currentScale > 0.4) pdfViewer.currentScale -= 0.2;
                },

                performSearch() {
                    if (!eventBus || !this.searchQuery) return;

                    eventBus.dispatch('find', {
                        type: 'find',
                        query: this.searchQuery,
                        highlightAll: true,
                        caseSensitive: false,
                        findPrevious: false,
                    });
                },

                findNext() {
                    if (!eventBus) return;

                    eventBus.dispatch('find', {
                        type: 'again',
                        query: this.searchQuery,
                        highlightAll: true,
                        caseSensitive: false,
                        findPrevious: false,
                    });
                },

                findPrev() {
                    if (!eventBus) return;

                    eventBus.dispatch('find', {
                        type: 'again',
                        query: this.searchQuery,
                        highlightAll: true,
                        caseSensitive: false,
                        findPrevious: true,
                    });
                },

                toggleFit() {
                    if (!pdfViewer) return;

                    if (pdfViewer.currentScaleValue === 'page-fit' || pdfViewer.currentScaleValue === 'auto') {
                        pdfViewer.currentScaleValue = 'page-width';
                    } else {
                        pdfViewer.currentScaleValue = 'page-fit';
                    }
                },
            };
        }
    </script>
@endpush