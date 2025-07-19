<Table>
  <TableHeader>
    <TableRow>
      <TableHead>ID</TableHead>
      <TableHead>Jenis Layanan</TableHead>
      <TableHead>Nama Pemohon</TableHead>
      <TableHead>Tanggal Pengajuan</TableHead>
      <TableHead>Status</TableHead>
      <TableHead>Aksi</TableHead>
    </TableRow>
  </TableHeader>
  <TableBody>
    {permohonan.map((item) => (
      <TableRow key={item.id}>
        <TableCell>{item.id}</TableCell>
        <TableCell>{item.jenis_layanan}</TableCell>
        <TableCell>{item.nama_pemohon}</TableCell>
        <TableCell>{item.tanggal_pengajuan}</TableCell>
        <TableCell>
          <Badge variant={
            item.status === 'approved' ? 'success' :
            item.status === 'rejected' ? 'destructive' : 'secondary'
          }>
            {item.status}
          </Badge>
        </TableCell>
        <TableCell>
          {item.status === 'pending' && (
            <div className="flex gap-2">
              <Button onClick={() => handleStatusUpdate(item.id, 'approved')} size="sm">Setujui</Button>
              <Button onClick={() => handleStatusUpdate(item.id, 'rejected')} size="sm" variant="destructive">Tolak</Button>
            </div>
          )}
        </TableCell>
      </TableRow>
    ))}
  </TableBody>
</Table>
