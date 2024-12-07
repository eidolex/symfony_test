import type { Session } from "~/types/session";
import backendClient from "./client";

export async function getSessions(params: { type?: string } = {}) {
  return (
    await backendClient.get<{
      data: {
        [key: string]: {
          types: {
            [key: string]: number;
          };
          sessions: Session[];
        };
      };
    }>("/api/v1/sessions", {
      params,
    })
  ).data;
}
