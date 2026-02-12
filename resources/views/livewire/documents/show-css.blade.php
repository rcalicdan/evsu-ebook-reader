@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf_viewer.min.css">

    <style>
        #viewerContainer::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        #viewerContainer::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #viewerContainer::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 5px;
            border: 2px solid #f1f1f1;
        }

        #viewerContainer::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .pdfViewer .page {
            margin: 10px auto !important;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .textLayer .highlight {
            background-color: rgba(255, 255, 0, 0.4);
            border-radius: 2px;
            cursor: pointer;
        }

        .textLayer .highlight.selected {
            background-color: rgba(220, 38, 38, 0.6);
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        }

        #viewerContainer {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        body.modal-open {
            overflow: hidden;
        }
    </style>
@endpush
