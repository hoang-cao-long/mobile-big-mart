import { Entity, Column, PrimaryGeneratedColumn } from 'typeorm';

@Entity({name: 'tblUnit'})
export class UnitEntity {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    name?: string;

    @Column({nullable: true})
    value?: string;
}