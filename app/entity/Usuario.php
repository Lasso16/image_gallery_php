<?php
namespace dwes\app\entity;

class Usuario implements IEntity {
    /**
     * Summary of id
     * @var 
     */
    private $id;
    /**
     * Summary of username
     * @var string
     */
    private string $username;
    /**
     * Summary of password
     * @var string
     */
    private string $password;
    /**
     * Summary of role
     * @var string
     */
    private string $role;

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function esAdmin(): bool {
        return strtoupper($this->role) === 'ROLE_ADMIN';
    }

	public function setUsername(string $username): void {
        $this->username = $username;
    }

	public function setPassword(string $password): void {
        $this->password = $password;
    }

	public function setRole(string $role): void {
        $this->role = $role;
    }

	

    public function toArray(): array
    {
        return ['id' => $this->id, 'username' => $this->username, 'role' => $this->role, 'password' => $this->password];

    }
}