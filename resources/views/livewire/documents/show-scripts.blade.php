@push('scripts')
    <script>
        function documentViewer() {
            let pdfDoc = null;
            let pdfViewer = null;
            let pdfLinkService = null;
            let pdfFindController = null;
            let eventBus = null;
            let loadingTask = null;

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
                

                init() {
                    pdfjsLib.GlobalWorkerOptions.workerSrc =
                        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                },

                openPreview(url) {
                    this.showPreview = true;
                    this.loading = true;
                    this.error = false;
                    this.searchQuery = '';
                    this.matchesCount = {
                        current: 0,
                        total: 0
                    };

                    setTimeout(() => {
                        this.initializeViewer(url);
                    }, 50);
                },

                closePreview() {
                    this.showPreview = false;
                    this.showMobileSearch = false;
                    this.searchQuery = '';

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
                        });

                        pdfLinkService.setViewer(pdfViewer);


                        eventBus.on('pagesinit', () => {
                            if (window.innerWidth < 768) {
                                pdfViewer.currentScaleValue = 'page-width';
                            } else {
                                pdfViewer.currentScaleValue = 'auto';
                            }

                            this.loading = false;
                        });

                        eventBus.on('pagechanging', (evt) => {
                            this.page = evt.pageNumber;
                            this.pageInput = evt.pageNumber;
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
