export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}
export interface Post {
    id: number,
    user: User,
    slug: string,
    type: string,
    title: string,
    content: string,
    excerpt: string,
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
