<style>
/* Extra Responsive Design for All Mobile Devices */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .metric-card {
        padding: 1rem;
        gap: 0.75rem;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        font-size: 1.5rem;
    }

    .metric-number {
        font-size: 1.25rem;
    }

    .metric-label {
        font-size: 0.8rem;
    }

    .participant-table thead th {
        padding: 1rem 0.75rem;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .participant-table tbody td {
        padding: 1.25rem 0.75rem;
    }

    .participant-name {
        font-size: 1rem;
    }

    .participant-region {
        font-size: 0.8rem;
    }

    .status-badge {
        padding: 6px 10px;
        font-size: 0.75rem;
    }

    .category-badge {
        padding: 4px 8px;
        font-size: 0.75rem;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .metric-card {
        padding: 0.875rem;
        gap: 0.5rem;
        border-radius: 12px;
    }

    .metric-icon {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
    }

    .metric-number {
        font-size: 1.1rem;
        margin-bottom: 0.125rem;
    }

    .metric-label {
        font-size: 0.75rem;
        letter-spacing: 0.2px;
    }

    .flex-actions {
        flex-direction: column;
        gap: 0.75rem;
        align-items: stretch;
    }

    .stats-summary {
        text-align: center;
        padding: 0.75rem;
        border-radius: 16px;
        font-size: 0.85rem;
    }

    .participant-table {
        font-size: 0.9rem;
        border-spacing: 0 4px;
        margin: -4px 0;
    }

    .participant-table thead th {
        padding: 0.875rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .participant-table tbody td {
        padding: 1rem 0.5rem;
    }

    .participant-row {
        margin-bottom: 4px;
        border-radius: 8px;
    }

    .participant-name {
        font-size: 0.95rem;
        font-weight: 600;
    }

    .participant-region {
        font-size: 0.75rem;
    }

    .status-badge {
        padding: 4px 8px;
        font-size: 0.7rem;
        border-radius: 16px;
    }

    .category-badge {
        padding: 3px 6px;
        font-size: 0.7rem;
        border-radius: 12px;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .empty-state-icon {
        font-size: 2.5rem;
    }

    .empty-state-text {
        font-size: 1rem;
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .metric-card {
        padding: 0.75rem;
        gap: 0.5rem;
        justify-content: center;
        text-align: center;
    }

    .metric-icon {
        width: 36px;
        height: 36px;
        font-size: 1.1rem;
    }

    .metric-number {
        font-size: 1rem;
        margin-bottom: 0.125rem;
    }

    .metric-label {
        font-size: 0.7rem;
    }

    .flex-actions {
        gap: 0.5rem;
    }

    .stats-summary {
        padding: 0.5rem;
        font-size: 0.8rem;
        border-radius: 12px;
    }

    .participant-table thead th {
        padding: 0.75rem 0.375rem;
        font-size: 0.7rem;
        text-align: center;
    }

    .participant-table tbody td {
        padding: 0.875rem 0.375rem;
        text-align: center;
    }

    .participant-table tbody td:first-child {
        text-align: left;
    }

    .participant-info {
        gap: 1px;
    }

    .participant-name {
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .participant-region {
        font-size: 0.7rem;
    }

    .status-badge {
        padding: 3px 6px;
        font-size: 0.65rem;
        border-radius: 12px;
    }

    .category-badge {
        padding: 2px 4px;
        font-size: 0.65rem;
        border-radius: 8px;
    }

    .empty-state {
        padding: 1.5rem 0.75rem;
    }

    .empty-state-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .empty-state-text {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.375rem;
        margin-bottom: 0.75rem;
    }

    .metric-card {
        padding: 0.625rem;
        gap: 0.375rem;
        border-radius: 8px;
    }

    .metric-icon {
        width: 32px;
        height: 32px;
        font-size: 1rem;
    }

    .metric-number {
        font-size: 0.9rem;
        margin-bottom: 0.0625rem;
    }

    .metric-label {
        font-size: 0.65rem;
        letter-spacing: 0.1px;
    }

    .flex-actions {
        gap: 0.375rem;
    }

    .stats-summary {
        padding: 0.375rem;
        font-size: 0.75rem;
        border-radius: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .stats-summary span {
        margin: 0.125rem;
    }

    .participant-table {
        font-size: 0.85rem;
        border-spacing: 0 2px;
        margin: -2px 0;
    }

    .participant-table thead th {
        padding: 0.625rem 0.25rem;
        font-size: 0.65rem;
        font-weight: 500;
    }

    .participant-table tbody td {
        padding: 0.75rem 0.25rem;
    }

    .participant-row {
        margin-bottom: 2px;
        border-radius: 6px;
    }

    .participant-info {
        gap: 0.5px;
    }

    .participant-name {
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1.1;
    }

    .participant-region {
        font-size: 0.65rem;
    }

    .region-icon {
        font-size: 0.6rem;
    }

    .status-badge {
        padding: 2px 4px;
        font-size: 0.6rem;
        border-radius: 8px;
        letter-spacing: 0.2px;
    }

    .category-badge {
        padding: 1px 3px;
        font-size: 0.6rem;
        border-radius: 6px;
    }

    .category-icon {
        font-size: 0.7rem;
    }

    .empty-state {
        padding: 1.25rem 0.5rem;
        border-radius: 8px;
    }

    .empty-state-icon {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        font-size: 0.8rem;
    }
}

@media (max-width: 360px) {
    .stats-grid {
        gap: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .metric-card {
        padding: 0.5rem;
        gap: 0.25rem;
    }

    .metric-icon {
        width: 28px;
        height: 28px;
        font-size: 0.9rem;
    }

    .metric-number {
        font-size: 0.8rem;
        margin-bottom: 0;
    }

    .metric-label {
        font-size: 0.6rem;
    }

    .flex-actions {
        gap: 0.25rem;
    }

    .stats-summary {
        padding: 0.25rem;
        font-size: 0.7rem;
        border-radius: 6px;
    }

    .participant-table thead th {
        padding: 0.5rem 0.125rem;
        font-size: 0.6rem;
    }

    .participant-table tbody td {
        padding: 0.625rem 0.125rem;
    }

    .participant-row {
        margin-bottom: 1px;
        border-radius: 4px;
    }

    .participant-name {
        font-size: 0.8rem;
    }

    .participant-region {
        font-size: 0.6rem;
    }

    .status-badge {
        padding: 1px 3px;
        font-size: 0.55rem;
        border-radius: 6px;
    }

    .category-badge {
        padding: 0.5px 2px;
        font-size: 0.55rem;
        border-radius: 4px;
    }

    .empty-state {
        padding: 1rem 0.375rem;
    }

    .empty-state-icon {
        font-size: 1.5rem;
        margin-bottom: 0.375rem;
    }

    .empty-state-text {
        font-size: 0.75rem;
    }
}

/* Extra small devices and landscape phones */
@media (max-width: 320px) {
    .stats-grid {
        gap: 0.125rem;
    }

    .metric-card {
        padding: 0.375rem;
    }

    .metric-icon {
        width: 24px;
        height: 24px;
        font-size: 0.8rem;
    }

    .metric-number {
        font-size: 0.75rem;
    }

    .metric-label {
        font-size: 0.55rem;
    }

    .stats-summary {
        padding: 0.125rem;
        font-size: 0.65rem;
    }

    .participant-table thead th {
        padding: 0.375rem 0.0625rem;
        font-size: 0.55rem;
    }

    .participant-table tbody td {
        padding: 0.5rem 0.0625rem;
    }

    .participant-name {
        font-size: 0.75rem;
    }

    .participant-region {
        font-size: 0.55rem;
    }

    .status-badge {
        padding: 0.5px 2px;
        font-size: 0.5rem;
    }

    .category-badge {
        padding: 0.25px 1px;
        font-size: 0.5rem;
    }
}

/* Landscape orientation adjustments */
@media (max-height: 500px) and (orientation: landscape) {
    .stats-grid {
        margin-bottom: 0.5rem;
    }

    .metric-card {
        padding: 0.5rem;
    }

    .participant-table tbody td {
        padding: 0.5rem 0.25rem;
    }

    .participant-row {
        margin-bottom: 2px;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    .metric-card {
        min-height: 60px;
    }

    .participant-row {
        min-height: 60px;
    }

    .participant-table tbody td {
        padding: 0.75rem;
    }

    .status-badge, .category-badge {
        min-height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .metric-card, .participant-row {
        border-width: 0.5px;
    }

    .status-badge, .category-badge {
        border-width: 0.5px;
    }
}
</style>
<?php /**PATH C:\test\apk\mangkatan\resources\views/components/extra-responsive.blade.php ENDPATH**/ ?>