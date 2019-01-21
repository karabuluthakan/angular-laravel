export interface IUser {
    id: number,
    username: string,
    firstname: string,
    lastname: string,
    email: string,
    role_id: number,
    avatar: string,
    created_at?: string,
    password?: string,
    password_confirmation?: string,
    status: number,
    _avatar?: File
}
