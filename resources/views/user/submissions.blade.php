@extends('user.layout', ['pageTitle' => 'Submit ', 'pageTitleSpan' => 'Documents'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>Document <span>Submission</span> Room</h2>
        <p>Use this page to upload required clearances, medical certificates, and parental consent forms for the sports unit review.</p>
    </div>

    <div class="data-table" style="padding: 32px; border-bottom: 4px solid var(--maroon);">
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
                
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Document Type</label>
                    <select class="form-control" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="" disabled selected>Select the type of document</option>
                        <option value="medical">Medical Certificate</option>
                        <option value="consent">Parental Consent</option>
                        <option value="waiver">Waiver Form</option>
                        <option value="other">Other Clearances</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Notes (Optional)</label>
                    <input type="text" class="form-control" placeholder="Add any details about this document..." style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                </div>
            </div>

            <div style="border: 2px dashed var(--maroon); background: rgba(122,20,40,0.02); padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); margin-bottom: 24px;" onclick="document.getElementById('fileUpload').click()">
                <i class='bx bx-cloud-upload' style="font-size: 3rem; color: var(--maroon); margin-bottom: 12px;"></i>
                <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.2rem; color: var(--charcoal);">Drag and drop to upload</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">or click to browse files (PDF, JPG, PNG)</p>
                <input type="file" id="fileUpload" style="display: none;">
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-upload'></i> Submit Document
                </button>
            </div>
        </form>
    </div>
@endsection
