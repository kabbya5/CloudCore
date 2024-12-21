import {defineStore} from 'pinia';

export const useAuthentication = defineStore('auth', () => {
    const token = ref<string|null> (null);
    const user = ref<object | null> (null);

    const tokenData = localStorage.getItem('authToken');
    if (tokenData) {
        const parsedToken = JSON.parse(tokenData);
        if (parsedToken.expiresAt > Date.now()) {
            token.value = parsedToken.value;
        } else {
            localStorage.removeItem('authToken');
        }
    }

    const storedUser = localStorage.getItem('user');
    if (storedUser) {
        user.value = JSON.parse(storedUser);
    }

    const setToken = (newToken: string): void => {
        
        const expirationTime = Date.now() + 2 * 24 * 60 * 60 * 1000; // 2 days
        const tokenData = {
            value: newToken,
            expiresAt: expirationTime,
        };

        localStorage.setItem('authToken', JSON.stringify(tokenData));
        token.value = newToken; 
    
    };

    const getToken = (): string | null => {
        const tokenData = localStorage.getItem('authToken');
        if (tokenData) {
            const parsedToken = JSON.parse(tokenData);
            if (parsedToken.expiresAt > Date.now()) {
                token.value = parsedToken.value; 
                return parsedToken.value;
            } else {
                clearToken(); 
            }
        }
        
        return null;
    };

    const setUser = (newUser: object): void => {
        localStorage.setItem('user', JSON.stringify(newUser));
        user.value = newUser; 
    };

    const getUser = async (): Promise<{ name: string | null, email: string | null }> => {
        try {
            const storedUser = localStorage.getItem('user');
            if (storedUser) {
                const userData = JSON.parse(storedUser);
                return {
                    name: userData.name ?? null,
                    email: userData.email ?? null
                };
            }
        } catch (error) {
            console.error("Error getting user data:", error);
        }
        
        return { name: null, email: null };
    };

    const clearToken = (): void => {
        token.value = null;
        localStorage.removeItem('authToken');
    };


    const clearAuthData = (): void => {
        user.value = null;
        clearToken();
        localStorage.removeItem('user'); 
    };

    return {
        token,
        user,
        setToken,
        setUser,
        getToken,
        getUser,
        clearToken,
        clearAuthData,
    };
})