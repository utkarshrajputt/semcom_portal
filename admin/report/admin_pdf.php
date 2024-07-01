<div id="pdfDiv" class="container mt-5" style="display:none;">
<h3 class="text-center"><u>PDF REPORT</u></h3>
    <form id="pdfForm" method="post" action="../admin/report/pdfData.php" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="mb-3">
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="singleRadio" value="single" checked onclick="toggleEntry('student', 'single')">
                    <label class="form-check-label" for="singleRadio">Single Entry</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="rangeRadio" value="range" onclick="toggleEntry('student', 'range')">
                    <label class="form-check-label" for="rangeRadio">Range Entry</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="allRadio" value="all" onclick="toggleEntry('student', 'all')">
                    <label class="form-check-label" for="allRadio">All</label>
                </div>
            </div>
        </div>

        <!-- Single entry section -->
        <div class="form-group col-md-6" id="studentSingleEntry">
            <label for="studentSingle">Single Entry</label>
            <select class="form-control" id="studentSingle" name="studentSingle"></select>
        </div>

        <!-- Range entry section -->
        <div class="form-group col-md-6" id="studentRangeEntry" style="display: none;">
            <label for="studentRangeStart">Range Entry</label>
            <div class="row">
                <div class="col-md-6">
                    <!-- <input type="number" class="form-control mb-2" id="studentRangeStart" name="studentRangeStart" placeholder="Start ID"> -->
                    <select class="form-control mb-2" id="studentRangeStart" name="studentRangeStart"></select>
                </div>
                <div class="col-md-6">
                    <!-- <input type="number" class="form-control" id="studentRangeEnd" name="studentRangeEnd" placeholder="End ID"> -->
                    <select class="form-control" id="studentRangeEnd" name="studentRangeEnd"></select>
                </div>
            </div>
        </div>

        <!-- All section -->
        <div class="form-group col-md-6" id="studentAllEntry" style="display: none;">
            <label for="studentAll">*All Students data get printed in pdf</label>
            <input type="hidden" id="firstValue" name="startPDF">
            <input type="hidden" id="lastValue" name="endPDF">
        </div>

        <!-- Submit button -->
        <div class="col-md-6 d-flex justify-content-end mt-2">
            <button id="pdfSubmit" name="pdf_submit" type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>
</div>


<!-- Your custom scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select the form and input elements
        const form = document.querySelector('form');
        const startInput = document.getElementById('studentRangeStart');
        const endInput = document.getElementById('studentRangeEnd');

        // Function to handle form submission
        form.addEventListener('pdfSubmit', function(event) {
            // Prevent form submission if validation fails
            if (!validateRange()) {
                event.preventDefault();
            }
        });


        // Function to validate range
        function validateRange() {
            // Get the values from input fields
            const start = parseInt(startInput.value, 10);
            const end = parseInt(endInput.value, 10);

            // Check if end is greater than start
            if (end <= start) {
                // Display error message (you can customize this part)
                alert('End value must be greater than Start value.');
                return false; // Validation fails
            }

            return true; // Validation passes
        }

    });
    // Validate the form based on the selected radio button
    function validateForm() {
        var entryType = document.querySelector('input[name="entryTypeStudent"]:checked');
        if (!entryType) {
            alert('Please select an entry type.');
            return false;
        }

        if (entryType.value === 'single') {
            var singleInput = document.getElementById('studentSingle');
            if (!singleInput.value.trim()) {
                alert('Please enter student credential.');
                return false;
            }
        } else if (entryType.value === 'range') {
            var startInput = document.getElementById('studentRangeStart');
            var endInput = document.getElementById('studentRangeEnd');

            if (!startInput.value.trim() || !endInput.value.trim()) {
                alert('Please enter both start and end IDs.');
                return false;
            }
        }

        return true; // Form is valid
    }

    // Toggle form sections based on radio button selection
    function toggleEntry(role, entryType) {
        var allEntry = document.getElementById(role + 'AllEntry');
        var singleEntry = document.getElementById(role + 'SingleEntry');
        var rangeEntry = document.getElementById(role + 'RangeEntry');

        allEntry.style.display = (entryType === 'all') ? 'block' : 'none';
        singleEntry.style.display = (entryType === 'single') ? 'block' : 'none';
        if (rangeEntry) {
            rangeEntry.style.display = (entryType === 'range') ? 'block' : 'none';
        }

        if (entryType === 'all') {
            var studentRangeStart = document.getElementById('studentRangeStart');
            var options = studentRangeStart.options;
            var firstValue = '';
            var lastValue = '';

            // Find the first enabled option value
            for (var i = 0; i < options.length; i++) {
                if (options[i].disabled === false) {
                    firstValue = options[i].value;
                    break;
                }
            }

            // Find the last option value
            for (var i = options.length - 1; i >= 0; i--) {
                if (options[i].disabled === false) {
                    lastValue = options[i].value;
                    break;
                }
            }

            // Set the hidden input values
            document.getElementById('firstValue').value = firstValue;
            document.getElementById('lastValue').value = lastValue;

        }
    }
</script>
    