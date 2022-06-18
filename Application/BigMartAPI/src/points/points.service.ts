import { HttpException, HttpStatus, Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { CustomerEntity } from 'src/customers/entity/customers.entity';
import { Repository } from 'typeorm';
import { PointEntity } from './entity/points.entity';

@Injectable()
export class PointsService {

    constructor(@InjectRepository(PointEntity) private readonly pointModel: Repository<PointEntity>) {}
    
    
    async findAll(): Promise<PointEntity[]> {
        try {
            return this.pointModel.createQueryBuilder('p')
            .innerJoinAndMapOne('p.customer_id', CustomerEntity, 'c', 'c.id = p.customer_id')
            .getMany(); 
            } catch (err) {
            throw new HttpException({
                status: HttpStatus.FORBIDDEN,
                error: 'Viet, Long ga qua, bi loi server roi',
                }, HttpStatus.FORBIDDEN);
            }
    }

    async findOne(id: number): Promise<PointEntity> {
        try {
            return this.pointModel.createQueryBuilder('p')
            .innerJoinAndMapOne('p.customer_id', CustomerEntity, 'c', 'c.id = p.customer_id')
            .where("p.id = "+`"${id}"`)
            .getOne()
            } catch (err) {
            throw new HttpException({
                status: HttpStatus.FORBIDDEN,
                error: 'Viet, Long ga qua, bi loi server roi',
                }, HttpStatus.FORBIDDEN);
            }
    }

    async update(id: number, payment: PointEntity){
        try {
            await this.pointModel.update(id, payment)
            } catch (err) {
            throw new HttpException({
                status: HttpStatus.FORBIDDEN,
                error: 'Viet, Long ga qua, bi loi server roi',
                }, HttpStatus.FORBIDDEN);
            }
    }

    async addNew(payment: PointEntity): Promise<PointEntity> {
        try {
            return await this.pointModel.save(payment)
            } catch (err) {
            throw new HttpException({
                status: HttpStatus.FORBIDDEN,
                error: 'Viet, Long ga qua, bi loi server roi',
                }, HttpStatus.FORBIDDEN);
            }
    }

    async deleteOne(id: number): Promise<void>{
        try {
            await this.pointModel.delete(id)
            } catch (err) {
            throw new HttpException({
                status: HttpStatus.FORBIDDEN,
                error: 'Viet, Long ga qua, bi loi server roi',
                }, HttpStatus.FORBIDDEN);
            }
    }
}
