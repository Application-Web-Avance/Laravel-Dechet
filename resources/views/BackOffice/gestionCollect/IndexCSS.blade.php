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
</style>