import backendClient from "./client";

type BookingDto = {
  name: string;
  email: string;
  phone: string;
  items: {
    id: number;
  }[];
};

export async function booking(data: BookingDto) {
  return (
    await backendClient.post<{
      message: string;
    }>("/api/v1/bookings", data)
  ).data;
}
