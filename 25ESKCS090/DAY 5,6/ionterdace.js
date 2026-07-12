// ==========================================
// MODULE 1: LOCAL ARRAY DATA MANAGEMENT (Day 5)
// ==========================================

// Structured local array containing Indian Army data objects
const armyRegiments = [
    {
        name: "Infantry Regiment",
        role: "Frontline Combat",
        motto: "Victory Everywhere",
        details: "The core combat arm that engages with the enemy face-to-face. They physically capture and hold ground in challenging operational conditions."
    },
    {
        name: "Artillery Regiment",
        role: "Long-Range Firepower",
        motto: "Everywhere with Glory",
        details: "Provides massive long-range firepower support to advancing columns using heavy guns, multi-barrel rocket systems, and precision missiles."
    },
    {
        name: "Armoured Corps",
        role: "Shock & Mechanized Thrust",
        motto: "Valour and Fortitude",
        details: "The fast-moving armored punch of the army utilizing main battle tanks to strike deep into enemy territory with high mobility."
    }
];

// Generates and inserts local HTML cards dynamically from the array above
function loadLocalRegiments() {
    let cardHTML = "";
    
    // Set total count dynamically on the UI badge
    $("#regimentCount").text(`${armyRegiments.length} Active Regiments`);

    // Iterating over data objects to inject custom layout structure
    armyRegiments.forEach(regiment => {
        cardHTML += `
            <div class="col target-search-card" data-search-key="${regiment.name.toLowerCase()}">
                <div class="card h-100 shadow-sm regiment-card">
                    <div class="card-body">
                        <span class="badge bg-success-subtle text-success mb-2">${regiment.role}</span>
                        <h5 class="card-title fw-bold text-dark">${regiment.name}</h5>
                        <p class="text-muted small italic mb-3">Motto: "${regiment.motto}"</p>
                        
                        <button class="btn btn-outline-success btn-sm toggle-details-btn">Show Details</button>
                        
                        <div class="hidden-details mt-3 p-3">
                            <p class="card-text small text-secondary mb-0">${regiment.details}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    $("#regimentContainer").html(cardHTML);
}


// ==========================================
// MODULE 2: NETWORKING AND API FETCHING (Day 6)
// ==========================================

const API_ENDPOINT = "https://jsonplaceholder.typicode.com/posts";

function fetchLiveBulletins() {
    const statusBox = $("#statusContainer");
    const cardsBox = $("#apiDataContainer");

    // Clear previous elements and switch view mode to "Loading state"
    cardsBox.empty();
    statusBox.removeClass("d-none alert-danger").addClass("alert alert-info text-center")
             .html('<div class="spinner-border spinner-border-sm text-primary me-2"></div> Running secure connection handshake with remote endpoint...');

    // Performing asynchronous HTTP network fetch call
    fetch(API_ENDPOINT)
        .then(response => {
            if (!response.ok) {
                throw new Error("API server returned invalid structural sync status.");
            }
            return response.json(); // Map raw stream data into JSON object
        })
        .then(data => {
            // Subset the massive stream array to 4 elements for clean layout fitting
            const subsetData = data.slice(0, 4);
            statusBox.addClass("d-none"); // Deactivate loading indicator panel

            let apiHTML = "";
            subsetData.forEach(item => {
                apiHTML += `
                    <div class="col target-search-card" data-search-key="${item.title.toLowerCase()}">
                        <div class="card h-100 shadow-sm api-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">Bulletin Node #${item.id}</span>
                                    <span class="text-success small fw-bold">• Stream Synchronized</span>
                                </div>
                                <h5 class="card-title text-capitalize fw-bold text-primary">${item.title}</h5>
                                <p class="card-text text-secondary small mb-0">${item.body}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
            // Append generated blocks smoothly using jQuery fadeIn animation wrapper
            cardsBox.html(apiHTML).hide().fadeIn(400);
        })
        .catch(err => {
            // Fallback UI State if the internet drops or connection breaks
            statusBox.removeClass("alert-info").addClass("alert alert-danger")
                     .html(`<strong>Network Transmission Fault:</strong> ${err.message}. Re-attempt server connection.`);
        });
}


// ==========================================
// MODULE 3: INTERACTIVE CONTROLS AND FILTERS
// ==========================================

$(document).ready(function() {
    // Render static data arrays upon standard document layout readiness
    loadLocalRegiments();

    // jQuery SlideToggle binding with contextual text swap logic loops
    $("#regimentContainer").on("click", ".toggle-details-btn", function() {
        const currentBtn = $(this);
        const descriptionPanel = currentBtn.next(".hidden-details");
        
        descriptionPanel.slideToggle(250, function() {
            if (descriptionPanel.is(":visible")) {
                currentBtn.text("Hide Details").removeClass("btn-outline-success").addClass("btn-success text-white");
            } else {
                currentBtn.text("Show Details").removeClass("btn-success text-white").addClass("btn-outline-success");
            }
        });
    });

    // Binding live content button triggers to network modules
    $("#fetchApiData").click(function() {
        fetchLiveBulletins();
    });

    // Custom real-time search evaluation input engine matrix
    $("#searchBar").on("keyup", function() {
        const currentQuery = $(this).val().toLowerCase().trim();
        
        $(".target-search-card").each(function() {
            const cardKeywords = $(this).attr("data-search-key") || "";
            // Display item if search string matches metadata key, else slide out
            if (cardKeywords.includes(currentQuery)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});