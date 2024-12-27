export function getAuthInitials(firstName: string | null, lastName: string | null) {
    const firstInitial = firstName ?firstName.charAt(0).toUpperCase() : '';
    const lastInitial = lastName ? lastName.charAt(0).toUpperCase() : ''; 
    return `${firstInitial}${lastInitial}`;
}

export function getFormattedDate(date:string|null) {
    if(!date) return ' ';
    const formatter = new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    });
    return formatter.format(new Date(date));
}