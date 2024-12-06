import {defineStore} from "pinia";


export const useSessionStore = defineStore('session', async () => {
    const {data} = await useFetch<{
       [key: string]: {
           types: {
               [key: string]: number;
           }
           sessions: {
               id: number;
               type: string;
               time: string;
               trainer: string;
               duration: string;
               price: number;
           }[]
       }
    }>('http://localhost:8000/api/v1/session');

    return {
        data,
    }
});
