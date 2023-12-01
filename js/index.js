// Import functions
import { redirectToAuthCodeFlow, getAccessToken } from "./authCodeWithPkce";

const clientId = "7d40960b51a942d78ad396bdfc2ff40b";
const params = new URLSearchParams(window.location.search);
const code = params.get("code");

// Use an immediately invoked async function to handle the asynchronous code
(async () => {
    if (!code) {
        redirectToAuthCodeFlow(clientId);
    } else {
        const accessToken = await getAccessToken(clientId, code);
        const profile = await fetchProfile(accessToken);
        populateUI(profile);
    }
})();

async function fetchProfile(code) {
    const result = await fetch("https://api.spotify.com/v1/me", {
        method: "GET", headers: { Authorization: `Bearer ${code}` }
    });

    return await result.json();
}

function populateUI(profile) {
    document.getElementById("displayName").innerText = profile.display_name;
    document.getElementById("avatar").setAttribute("src", profile.images[0].url);
    document.getElementById("id").innerText = profile.id;
    document.getElementById("email").innerText = profile.email;
    document.getElementById("uri").innerText = profile.uri;
    document.getElementById("uri").setAttribute("href", profile.external_urls.spotify);
    document.getElementById("url").innerText = profile.href;
    document.getElementById("url").setAttribute("href", profile.href);
    document.getElementById("imgUrl").innerText = profile.images[0].url;
}

function slide_info(){
    features = document.querySelectorAll("feature");
    alert(features[0]);
}
document.onload = function(){alert(1)};