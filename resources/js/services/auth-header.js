export default function authHeader() {
    let data = JSON.parse(localStorage.getItem('user'));
    if (data && data.access_token) {
        return {
            'Authorization': 'Bearer ' + data.access_token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
    } else {
        return {};
    }
}
