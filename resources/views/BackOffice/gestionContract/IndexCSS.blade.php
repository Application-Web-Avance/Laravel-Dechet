<style>
    /* Pagination styling */
    .pagination {
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
    }

    .pagination .page-item {
        margin: 0 0.25rem;
    }

    .pagination .page-link {
        border: 1px solid #007bff;
        border-radius: 50%;
        color: #007bff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
    }

    .pagination .page-link:hover:not(.disabled) {
        background-color: #e0f7ff;
        color: #007bff;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        border: none;
        background: none;
    }

    .action-btn i {
        font-size: 16px;
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

        /* CSS to ensure that text wraps properly within table cells */
    .table td, .table th {
        word-wrap: break-word;
        white-space: normal;
    }

    /* Media queries to hide some columns on small screens */
    @media (max-width: 768px) {
        .table th:nth-child(3), 
        .table td:nth-child(3),
        .table th:nth-child(4), 
        .table td:nth-child(4) {
            display: none; /* Hide columns for small screens */
        }
    }


    /* Adjustments for smaller screens */
    @media (max-width: 767px) {
        .card-title {
            font-size: 1.2rem;
        }

        .action-btn {
            width: 30px;
            height: 30px;
        }

        .pagination .page-link {
            width: 30px;
            height: 30px;
        }

        /* Stack the action buttons vertically */
        td .action-btn {
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Hide certain columns on small screens */
        .d-none.d-xl-table-cell {
            display: none !important;
        }

        .d-none.d-md-table-cell {
            display: none !important;
        }

        /* Adjust image size */
        td img {
            width: 40px;
            height: 40px;
        }
    }

        .statut-dropdown option {
        background-color: white;
    }

    .statut-dropdown option[value="en cours"] {
        color: #027CFF;
    }

    .statut-dropdown option[value="accepté"] {
        color: green;
    }

    .statut-dropdown option[value="refusé"] {
        color: red;
    }

    /* Modal Styles */
    .modal-content {
        background-color: #FAFAFA;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 20px;
    }

    .modal-header {
        border-bottom: none;
        background-color: #222E3C;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 15px;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #DDE1E5;
    }

    .btn-close-gn {
        border: none;
        font-size: 1.2rem;
        color: #ffffff
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 20px;
        color: #555;
        font-size: 1rem;
    }

    .modal-body p {
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .modal-footer {
        border-top: none;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        background-color: #E9E9E9;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .modal-footer .btn {
        background-color: #B7EF3F;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .modal-footer .btn:hover {
        background-color: #abe13b;
    }

    /* Hover effect for table cells */
    td[data-bs-toggle="modal"] {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    td[data-bs-toggle="modal"]:hover {
        background-color: #e0f7ff;
    }

    /* Modal Overlay */
    .modal-backdrop.show {
        opacity: 0.8;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .tooltip {
        display: none;
        position: absolute;
        background-color: #333;
        color: #fff;
        padding: 5px;
        border-radius: 4px;
        z-index: 1000;
    }

    .contract-end-date:hover .tooltip {
        display: block;
    }


</style>