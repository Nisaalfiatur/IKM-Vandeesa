<style>
    /* ===================================================
       MASTER DATA — SHARED DESIGN SYSTEM
       Primary: #4F46E5 | Secondary: #6366F1
       Success: #10B981 | Warning: #F59E0B | Danger: #EF4444
    =================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .master-container {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        animation: masterFadeIn 0.45s ease-out;
    }

    @keyframes masterFadeIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ---- Page Header ---- */
    .master-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .master-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        color: #9CA3AF;
        margin-bottom: 8px;
    }

    .master-breadcrumb-active { color: #4F46E5; font-weight: 600; }

    .master-page-title {
        font-size: 26px !important;
        font-weight: 800 !important;
        color: #1F2937 !important;
        margin: 0 0 4px 0 !important;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.5px;
    }

    .master-title-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .master-page-subtitle {
        color: #6B7280;
        font-size: 14px;
        margin: 0;
    }

    .master-btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: linear-gradient(135deg, #4F46E5, #6366F1);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        cursor: pointer;
        white-space: nowrap;
    }

    .master-btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5);
        color: #fff !important;
    }

    /* ---- Alert ---- */
    .master-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        transition: opacity 0.4s ease;
    }

    .master-alert-success {
        background: linear-gradient(135deg, #DCFCE7, #D1FAE5);
        color: #166534;
        border-left: 4px solid #10B981;
    }

    .master-alert-close {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        color: currentColor;
        opacity: 0.6;
        padding: 4px;
        display: flex;
        border-radius: 50%;
        transition: opacity 0.2s;
        flex-shrink: 0;
    }

    .master-alert-close:hover { opacity: 1; background: rgba(0,0,0,0.06); }

    /* ---- Stats Row ---- */
    .master-stats-row {
        display: flex;
        gap: 18px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .master-stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(229,231,235,0.7);
        flex: 1;
        min-width: 180px;
        max-width: 260px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .master-stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent, #4F46E5);
        border-radius: 16px 16px 0 0;
    }

    .master-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .master-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .master-stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #1F2937;
        line-height: 1.1;
    }

    .master-stat-label {
        font-size: 13px;
        color: #6B7280;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ---- Cards ---- */
    .master-card {
        background: #fff;
        border-radius: 18px !important;
        border: 1px solid rgba(229,231,235,0.6);
        box-shadow: 0 1px 8px rgba(0,0,0,0.05) !important;
        margin-bottom: 20px;
        transform: none !important;
    }

    .master-card:hover {
        transform: none !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    }

    .master-filter-card { padding: 18px 22px; }

    .master-filter-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* ---- Search ---- */
    .master-search-box {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .master-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    .master-search-input {
        width: 100% !important;
        padding: 11px 40px 11px 42px !important;
        border: 2px solid #E5E7EB !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        color: #374151 !important;
        background: #F9FAFB !important;
        transition: all 0.3s ease !important;
        outline: none !important;
        margin: 0 !important;
    }

    .master-search-input:focus {
        border-color: #4F46E5 !important;
        background: #fff !important;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1) !important;
    }

    .master-clear-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9CA3AF;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
        box-shadow: none;
    }

    .master-clear-btn:hover { color: #6B7280; background: #F3F4F6; transform: translateY(-50%) !important; box-shadow: none; }

    .master-result-count {
        font-size: 13px;
        color: #6B7280;
        padding: 8px 16px;
        background: #EEF2FF;
        border-radius: 8px;
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .master-result-count span { font-weight: 700; color: #4F46E5; }

    /* ---- Filter Select ---- */
    .master-filter-select-wrap {
        position: relative;
        min-width: 170px;
    }

    .master-filter-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    .master-filter-select {
        width: 100% !important;
        padding: 11px 16px 11px 38px !important;
        border: 2px solid #E5E7EB !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        color: #374151 !important;
        background: #F9FAFB !important;
        transition: all 0.3s ease !important;
        outline: none !important;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        margin: 0 !important;
    }

    .master-filter-select:focus {
        border-color: #4F46E5 !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1) !important;
    }

    /* ---- Table ---- */
    .master-table-card { padding: 0; overflow: hidden; }
    .master-table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .master-table { width: 100%; border-collapse: collapse; background: white; }

    .master-table thead th {
        background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        color: #3730A3;
        font-weight: 700;
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 14px 18px;
        white-space: nowrap;
        border-bottom: 2px solid #C7D2FE;
    }

    .master-table tbody td {
        padding: 14px 18px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #F3F4F6;
        color: #374151;
    }

    .master-table tbody tr { transition: background 0.18s ease; }
    .master-table tbody tr:hover { background: #F5F7FF; }
    .master-table tbody tr:last-child td { border-bottom: none; }
    .master-table tbody tr:nth-child(even) { background: #FAFAFA; }
    .master-table tbody tr:nth-child(even):hover { background: #F5F7FF; }

    .master-row-num {
        text-align: center;
        color: #9CA3AF;
        font-weight: 600;
        font-size: 13px;
    }

    /* ---- Badges ---- */
    .master-id-badge {
        font-family: 'Courier New', monospace;
        font-size: 12.5px;
        font-weight: 700;
        color: #4F46E5;
        background: #EEF2FF;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #C7D2FE;
        white-space: nowrap;
    }

    .master-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        background: linear-gradient(135deg, #F0FDF4, #DCFCE7);
        color: #166534;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid #BBF7D0;
    }

    .master-kategori-online {
        display: inline-flex; align-items: center;
        padding: 5px 12px;
        background: linear-gradient(135deg, #EFF6FF, #DBEAFE);
        color: #1D4ED8;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid #BFDBFE;
    }

    .master-kategori-offline {
        display: inline-flex; align-items: center;
        padding: 5px 12px;
        background: linear-gradient(135deg, #FFF7ED, #FED7AA);
        color: #9A3412;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid #FDBA74;
    }

    /* ---- Entity Info with avatar ---- */
    .master-entity-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .master-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .master-entity-name { font-weight: 600; color: #1F2937; }
    .master-entity-sub  { font-size: 12.5px; color: #6B7280; }

    /* ---- Action Buttons ---- */
    .master-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .master-btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid transparent;
        cursor: pointer;
        transition: all 0.22s ease;
        text-decoration: none !important;
        background: transparent;
        padding: 0;
        box-sizing: border-box;
        flex-shrink: 0;
    }

    .master-btn-edit {
        color: #4F46E5;
        border-color: #C7D2FE;
        background: #EEF2FF;
    }

    .master-btn-edit:hover {
        background: #4F46E5;
        color: #fff;
        border-color: #4F46E5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79,70,229,0.3);
    }

    .master-btn-delete {
        color: #EF4444;
        border-color: #FECACA;
        background: #FEF2F2;
    }

    .master-btn-delete:hover {
        background: #EF4444;
        color: #fff;
        border-color: #EF4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }

    /* ---- Empty State ---- */
    .master-empty-state,
    .master-no-results {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 24px;
        text-align: center;
    }

    .master-empty-icon {
        width: 100px;
        height: 100px;
        border-radius: 24px;
        background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366F1;
        margin-bottom: 20px;
    }

    .master-empty-state h3,
    .master-no-results h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1F2937;
        margin: 0 0 8px 0;
    }

    .master-empty-state p,
    .master-no-results p {
        font-size: 14px;
        color: #6B7280;
        margin: 0;
    }

    /* ---- Form Styles ---- */
    .master-form-container { max-width: 780px; }

    .master-form-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 28px;
        padding-bottom: 22px;
        border-bottom: 1px solid #E5E7EB;
    }

    .master-form-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .master-form-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1F2937;
        margin: 0 0 2px 0;
    }

    .master-form-header p {
        font-size: 13.5px;
        color: #6B7280;
        margin: 0;
        font-weight: 400;
    }

    .master-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .master-form-grid-full { grid-column: 1 / -1; }

    .master-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .master-form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #374151;
    }

    .master-form-label span.required {
        color: #EF4444;
        margin-left: 3px;
    }

    .master-form-input,
    .master-form-select,
    .master-form-textarea {
        width: 100% !important;
        padding: 11px 14px !important;
        border: 2px solid #E5E7EB !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        color: #1F2937 !important;
        background: #F9FAFB !important;
        transition: all 0.3s ease !important;
        outline: none !important;
        font-family: 'Inter', 'Segoe UI', sans-serif !important;
        margin: 0 !important;
    }

    .master-form-input:focus,
    .master-form-select:focus,
    .master-form-textarea:focus {
        border-color: #4F46E5 !important;
        background: #fff !important;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1) !important;
    }

    .master-form-input[readonly] {
        background: #F3F4F6 !important;
        color: #6B7280 !important;
        cursor: not-allowed;
    }

    .master-form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .master-form-hint {
        font-size: 12px;
        color: #9CA3AF;
        margin-top: 2px;
    }

    .master-form-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        padding-right: 40px !important;
    }

    .master-form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #E5E7EB;
    }

    .master-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: linear-gradient(135deg, #4F46E5, #6366F1);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        text-decoration: none;
    }

    .master-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79,70,229,0.45);
        color: #fff;
    }

    .master-btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: #fff;
        color: #6B7280;
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .master-btn-cancel:hover {
        background: #F9FAFB;
        border-color: #D1D5DB;
        color: #374151;
        transform: none;
        box-shadow: none;
    }

    /* File upload */
    .master-file-upload-area {
        border: 2px dashed #C7D2FE;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        background: #F5F7FF;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .master-file-upload-area:hover {
        border-color: #4F46E5;
        background: #EEF2FF;
    }

    .master-file-upload-area input[type="file"] {
        display: none;
    }

    .master-file-upload-icon { color: #6366F1; margin-bottom: 8px; }
    .master-file-upload-text { font-size: 13.5px; color: #4F46E5; font-weight: 600; }
    .master-file-upload-hint { font-size: 12px; color: #9CA3AF; margin-top: 4px; }

    .master-img-preview {
        width: 100%;
        max-width: 180px;
        height: 140px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #E0E7FF;
        display: block;
    }

    /* ---- Delete Confirm Card ---- */
    .master-delete-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(229,231,235,0.6);
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        padding: 32px;
        max-width: 600px;
    }

    .master-delete-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #FEE2E2;
    }

    .master-delete-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #EF4444;
        flex-shrink: 0;
    }

    .master-delete-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: #1F2937;
        margin: 0 0 4px 0;
    }

    .master-delete-header p {
        font-size: 13.5px;
        color: #6B7280;
        margin: 0;
        font-weight: 400;
    }

    .master-delete-detail {
        background: #F9FAFB;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #E5E7EB;
    }

    .master-delete-row {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #E5E7EB;
        font-size: 14px;
    }

    .master-delete-row:last-child { border-bottom: none; }

    .master-delete-key {
        width: 140px;
        font-weight: 600;
        color: #6B7280;
        flex-shrink: 0;
    }

    .master-delete-val { color: #1F2937; font-weight: 500; }

    .master-delete-warning {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #FEF3C7;
        border-radius: 10px;
        color: #92400E;
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 24px;
        border: 1px solid #FDE68A;
    }

    .master-delete-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .master-btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(239,68,68,0.3);
        text-decoration: none;
    }

    .master-btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239,68,68,0.45);
        color: #fff;
    }

    /* ---- Validation Error ---- */
    .master-error-text {
        font-size: 12px;
        color: #EF4444;
        font-weight: 500;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .master-form-input.is-invalid { border-color: #EF4444 !important; }
    .master-form-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important; }

    /* ---- Responsive ---- */
    @media (max-width: 768px) {
        .master-page-header { flex-direction: column; align-items: flex-start; }
        .master-form-grid { grid-template-columns: 1fr; }
        .master-stats-row { flex-direction: column; }
        .master-stat-card { max-width: 100%; }
        .master-filter-bar { flex-direction: column; align-items: stretch; }
        .master-search-box { min-width: unset; }
        .master-table thead th,
        .master-table tbody td { padding: 10px 12px; }
    }
</style>
